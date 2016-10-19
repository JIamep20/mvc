<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.10.2016
 * Time: 19:18
 */

namespace App\Controllers;


use Framework\DB;

class AdressBook extends Controller
{
    /**
     * 'admin' route handler
     * @param $p
     * @param $r
     * @throws \App\Exceptions\Exception
     */
    public function adminIndex($p, $r){

        return render('admin/index', [
            'admin_page' => true,
            'adresses' => assoc_array($this->prepare_search_query($p, $r)),
            'key' => $r->key,
            'city' => $r->city,
            'country' => $r->country,
            'cities' => assoc_array(DB::query("select name from city order by city.name")),
            'countries' => assoc_array(DB::query("select name from country order by country.name"))
        ]);
    }

    /**
     * '' route handler
     * @param $p
     * @param $r
     * @throws \App\Exceptions\Exception
     */
    public function guestIndex($p, $r)
    {

        return render('index', [
            'adresses' => assoc_array($this->prepare_search_query($p, $r)),
            'key' => $r->key,
            'city' => $r->city,
            'country' => $r->country,
            'cities' => assoc_array(DB::query("select name from city order by city.name")),
            'countries' => assoc_array(DB::query("select name from country order by country.name"))
        ]);
    }

    /**
     * Preparing search query according to request
     * @param $p
     * @param $r
     * @return mixed
     * @throws \App\Exceptions\Exception
     */
    protected function prepare_search_query($p, $r)
    {
        $query = "SELECT 
adress.id, users.first_name, users.last_name, country.name as country_name, city.name as city_name
FROM adress
  LEFT JOIN users ON adress.user_id = users.id
  LEFT JOIN city ON adress.city_id = city.id
  LEFT JOIN country ON city.country_id = country.id";

        if(isset($r->key) && length($r->key)) {
            $query = $this->prepare_condition($query, "(users.first_name like '%$r->key%' or users.last_name like '%$r->key%')");
        }

        if(isset($r->city) && length($r->city)) {
            $query = $this->prepare_condition($query, "city.name = '$r->city'");
        }

        if(isset($r->country) && length($r->country)) {
            $query = $this->prepare_condition($query, "country.name = '$r->country'");
        }


        $result = DB::query($query);

        return $result;
    }
}