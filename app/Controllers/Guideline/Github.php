<?php
namespace App\Controllers\Guideline;

use App\Models\Route;use Soda\Core\Http\Controller;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class Github extends Controller
{
    function index($id)
    {
        try {
            $route = Route::where('title', $id)->firstOrFail();

            $visitor = new Visitor();

            $visitor->referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL;
            $visitor->address = $_SERVER['REMOTE_ADDR'];
            $visitor->document = $route->title;

            try {
                $visitor->save();

//                Header('location: ' . $route->link);

                return $this->render('guideline.index', ['status' => 'ok', 'pageTitle'=> "Guideline | " . ucfirst($id), 'data' => $route->link]);
            } catch (\Exception $e) {
                return $this->render('guideline.index', ['status' => 'error', 'pageTitle'=>'title not found', 'data' => '']);
            }
        }catch (ModelNotFoundException $e) {
        }

        return $this->render('guideline.index', ['status' => 'title not found', 'pageTitle'=>'title not found', 'data' => '']);
    }
}