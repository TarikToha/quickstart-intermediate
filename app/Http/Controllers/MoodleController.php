<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MoodleController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->middleware('auth');
        $this->client = new Client(['cookies' => true,
            'headers' => ['User-Agent' => 'Safari/537.36'],
        ]);
    }

    public function index(Request $request)
    {
        if (Auth::user()->hasMoodle()) {
            return redirect('papers');
        }
        return view('moodle');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,moodle',
            'password' => 'required',
        ]);

        $data = $this->client->post('https://cse.buet.ac.bd/moodle/login/index.php', [
            'form_params' => [
                'username' => $request->username,
                'password' => $request->password,
            ]
        ])->getBody();

        $name = preg_split('/title=\"View profile\">/', $data);
        if (count($name) == 1) {
            echo "<h1 style='font-family: monospace'>You have no Moodle account</h1>";
            ob_flush();
            flush();
            sleep(5);
            return redirect('moodle');
        }

        $name = preg_split('/ \(/', $name[1])[0];

        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'moodle' => $request->username,
                'session' => date('Y-m-d H:i:s')
            ]);

        echo "<h1 style='font-family: monospace'>Your profile name of Moodle is " . $name . "</h1>";
        ob_flush();
        flush();
        sleep(5);
        return redirect('papers');
    }
}