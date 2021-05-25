<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Projeto;
use App\Desenvolvedor;
use App\Alocacao;

Route::get('/desenvolvedor-projetos', function () {

    $desenvolvedores = Desenvolvedor::with('projetos')->get();

    foreach($desenvolvedores as $d){
        echo "<p> Nome do Desenvolvedor: " . $d->nome . "</p>";
        echo "<p> Cargo: " . $d->cargo . "</p>";
        if(count($d->projetos)>0){

            echo "Projetos: <br>";
            echo "<ul>";
            foreach($d->projetos as $p){
                echo "<li>";
                echo "Nome: " . $p->nome . " | ";
                echo "Horas do projeto: " . $p->estimativa_horas . " | ";
                echo "Horas do trabalhadas: " . $p->pivot->horas_semanais;
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<hr>";
    }

   // return $desenvolvedores->toJson();

});

Route::get('/projetos-desenvolvedores', function () {

    $projetos = Projeto::with('desenvolvedores')->get();
    return $projetos->toJson();


});


Route::get('/alocar', function () {

    $proj = Projeto::find(4);
    if(isset($proj)){
        //$proj->desenvolvedores()->attach(1, ['horas_semanais'=>50]);
        $proj->desenvolvedores()->attach([
            2 => ['horas_semanais' => 20],
            3 => ['horas_semanais' => 30]
        ]);
    }


});

Route::get('/desalocar', function () {

    $proj = Projeto::find(4);
    if(isset($proj)){
        //$proj->desenvolvedores()->attach(1, ['horas_semanais'=>50]);
        $proj->desenvolvedores()->detach([1,2,3]);
    }


});