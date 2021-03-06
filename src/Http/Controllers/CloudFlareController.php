<?php

/*
 * This file is part of Laravel CloudFlare.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\CloudFlare\Http\Controllers;

use GrahamCampbell\CloudFlare\Clients\ClientInterface;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Auth;
use Request;

/**
 * This is the cloudflare controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CloudFlareController extends Controller
{
    /**
     * The client instance.
     *
     * @var \GrahamCampbell\CloudFlare\Clients\ClientInterface
     */
    protected $client;

    /**
     * The zone id.
     *
     * @var string
     */
    protected $zone;

    /**
     * Create a new cloudflare controller instance.
     *
     * @param \GrahamCampbell\CloudFlare\Clients\ClientInterface $client
     * @param string                                             $zone
     * @param string[]                                           $middleware
     *
     * @return void
     */
    public function __construct(ClientInterface $client, $zone, array $middleware)
    {
        $this->client = $client;
        $this->zone = $zone;

        foreach ($middleware as $class) {
            $this->middleware($class);
        }
    }

    /**
     * Display the index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return View::make('cloudflare::index');
    }

    /**
     * Display the traffic data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $raw = $this->client->get($this->zone, ['since' => -43200]);

        $data = json_decode($raw->getBody(), true)['result']['totals'];

        return View::make('cloudflare::data', ['data' => $data]);
    }
        public function getZone()
    {
        $raw = $this->client->getzone(['status'=>'active','page'=>1,'per_page'=>20,'order'=>'status','direction'=>'desc','match'=>'all']);

      $data = json_decode($raw->getBody(), true)['result'];
return $data;
    }
        public function getAddwhitelist()
    {
        $mode=Request::get('mode','whitelist');
        $ip=Request::get('ip');
$note=Auth::id().'-'.Auth::user()->username;

$data=["mode"=>"challenge","configuration"=>["target"=>"ip","value"=>$ip],"notes"=>$note];


        $raw = $this->client->getaddwhitelist(,$this->zone,$data);

      $data = json_decode($raw->getBody(), true)['result'];
return $data;
    }
   

}

