<?php

namespace App\Http\Controllers;

use App\Paper;
use App\Repositories\PaperRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaperController extends Controller
{
    /**
     * The paper repository instance.
     *
     * @var PaperRepository
     */
    protected $papers;
    private $path, $client;

    /**
     * Create a new controller instance.
     *
     * @param  PaperRepository $papers
     * @return void
     */
    public function __construct(PaperRepository $papers)
    {
        $this->middleware('moodle');
        $this->path = base_path() . '/storage/app/';
        $this->papers = $papers;
        $this->client = new Client(['cookies' => true,
            'headers' => ['User-Agent' => 'Safari/537.36'],
        ]);
    }

    /**
     * Display a list of all of the user's paper.
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('paper.index', [
            'papers' => $this->papers->papers(),
            'moodle' => Auth::user()->moodle,
        ]);
    }

    /**
     * Create a new paper.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'link' => 'required|url',
        ]);

        $url = parse_url($request->link);
        $host = $url['host'];
        switch ($host) {
            case 'ieeexplore.ieee.org':
                $url = $this->iEEE($url['path']);
                break;
            case 'www.sciencedirect.com':
                $url = $this->scienceDirect($request->link);
                break;
            case 'dl.acm.org':
                $url = $this->dlACM($request->link);
                break;
            case 'link.springer.com':
                $url = $this->springer($request->link);
                break;
            default:
                $url = null;
        }

        if (is_null($url)) {
            return view('common.nopaper');
        }

        $pdf = pathinfo($url, PATHINFO_FILENAME);
        if ($host == 'dl.acm.org') {
            $pdf = preg_split('/\.pdf\?/', $pdf)[0];
        }
        $pdf = $pdf . '.pdf';

        if ($host != 'link.springer.com') {
            $this->showProgress();
        }

        if (!$this->fileExists($pdf)) {
            set_time_limit(3600);
            if ($host != 'link.springer.com') {
                $data = $this->client->get($url)->getBody();
            } else {
                $data = $this->client->get($url, ['allow_redirects' => ['max' => 2, 'track_redirects' => true]]);
                if (array_key_exists('X-Guzzle-Redirect-Status-History', $data->getHeaders())) {
                    return view('common.nopaper');
                }
                $this->showProgress();
                $data = $data->getBody();
            }
            file_put_contents($this->path . $pdf, $data);
            $this->savePaperInDB($pdf);
        }

        echo '<h1 style="font-family: monospace"><a href="' . url('download_papers/' . $pdf) . '">' . $pdf . '</a></h1>';
    }

    private function iEEE($path)
    {
        $path = preg_split("/\//", $path);
        $count = count($path);
        $path = empty($path[$count - 1]) ? $path[$count - 2] : $path[$count - 1];
        $path = 'https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&arnumber=' . $path;
        $data = $this->client->get($path)->getBody();
        $data = preg_split('/<iframe src=\"/', $data);
        if (count($data) == 1) {
            return null;
        }
        return preg_split('/\"/', $data[1])[0];
    }

    private function scienceDirect($path)
    {
        $path = get_meta_tags($path);
        if (!array_key_exists('citation_pdf_url', $path)) {
            return null;
        }
        $path = $path['citation_pdf_url'];
        $data = $this->client->get($path)->getBody();
        $data = preg_split('/<a href=\"/', $data);
        if (count($data) == 1) {
            return null;
        }
        return preg_split('/\"/', $data[1])[0];
    }

    private function dlACM($path)
    {
        $data = $this->client->get($path)->getBody();
        $data = preg_split('/<meta name=\"citation_pdf_url\" content=\"/', $data);
        if (count($data) == 1) {
            return null;
        }
        $data = preg_split('/\"/', $data[1])[0];
        return $this->client->get($data, ['allow_redirects' => ['max' => 2, 'track_redirects' => true]])->getHeaders()['X-Guzzle-Redirect-History'][1];
    }

    private function springer($path)
    {
        $path = get_meta_tags($path);
        if (!array_key_exists('citation_pdf_url', $path)) {
            return null;
        }

        return urldecode($path['citation_pdf_url']);
    }

    private function fileExists($name)
    {
        return $this->papers->paperExists($name);
    }

    private function showProgress()
    {
        echo "<h1 style='font-family: monospace'>File is being downloaded. Please wait until the download link appears.</h1>";
        ob_flush();
        flush();
    }

    private function savePaperInDB($pdf)
    {
        $paper = new Paper;
        $paper->user_id = Auth::id();
        $paper->name = $pdf;
        $paper->save();
    }

    public function download($name)
    {
        return response()->download($this->path . $name);
    }

    /**
     * Destroy the given paper.
     *
     * @param  Request $request
     * @param  Paper $paper
     * @return Response
     */
    public function destroy(Request $request, Paper $paper)
    {
        if (Auth::user()->isAdmin()) {
            $paper->delete();
            unlink($this->path . $paper->name);
        }
        return redirect('/papers');
    }
}
