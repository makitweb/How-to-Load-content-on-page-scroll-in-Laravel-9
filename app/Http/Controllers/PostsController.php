<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;

class PostsController extends Controller
{
    private $rowperpage = 4;// Number of rowperpage

    public function index(){
        $data['rowperpage'] = $this->rowperpage;

        $data['totalrecords'] = Posts::select('*')->count();

        // Fetch records 
        $data['posts'] = Posts::select('*')
                        ->skip(0)
                        ->take($this->rowperpage)
                        ->get();

        return view('index',$data);               
    }

    // Fetch records 
    public function getPosts(Request $request){

        $start = $request->get('start');

        $records = Posts::select('*')
                        ->skip($start)
                        ->take($this->rowperpage)
                        ->get();

        $html = "";
        foreach($records as $record){
            $id = $record['id'];
            $title = $record['title'];
            $content = $record['content'];
            $link = $record['link'];

            $html .= '<div class="card w-75 post">
                <div class="card-body" >
                    <h5 class="card-title">'.$title.'</h5>
                    <p class="card-text">'.$content.'</p>
                    <a href="'.$link.'" target="_blank" class="btn btn-primary">Read more</a>
                </div>
            </div>';
        }

        $data['html'] = $html;
        return response()->json($data);
    }
}
