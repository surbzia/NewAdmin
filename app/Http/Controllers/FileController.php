<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Repositories\FileRepository;
class FileController extends Controller
{
    protected $file;
    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }
    public function index(Request $req){
        return $this->file->findByTableOnly($req->tablename, $req->q);
    }
    public function store(Request $request){
        $result = $this->file->create($request->attachements, $request->table_name, $request->ref_id, $request->type);
        return $result;
    }
    public function destroy(File $file){
        $this->file->delete($file);
        return response()->json(null, 204);
    }
    public function findByTable($table, $id, $type){
        return $this->file->findByTable($table,$id,$type);
    }
}
