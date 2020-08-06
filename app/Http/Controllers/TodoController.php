<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use App\User;
use Auth;

class TodoController extends Controller
{
    private $todo;

    //todoクラスのインスタンス化
    public function __construct(Todo $instanceClass)
    {
        $this->middleware('auth');
        $this->todo = $instanceClass;
        //$this->todo に引数で渡ってきたものを代入(private $todo; へアクセスして代入)
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd(Auth::guard());
        // $todos = $this->todo->all();
        // dd($todos);
        // Request::all();
        //DBからの全件取得(SELECT * FROM todos)
        // dd(compact('todos'));
        $todos = $this->todo->getByUserId(Auth::id());
        $user = Auth::user();
        // dd(compact('todos'));
        return view('todo.index', compact('todos', 'user'));
        //compact view側へ渡したい変数(todos)を記述
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
        //formタグで送信したPOST情報を取得
    {
        //
        $input = $request->all();
        $input['user_id'] = Auth::id();
        // dd($input);
        // dd($this->todo->fill($input));
        $this->todo->fill($input)->save();
        // dd(redirect()->to('todo'));
        return redirect()->route('todo.index');
        //一覧画面へ遷移
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *+
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $todo = $this->todo->find($id);
        //パラメーターで渡ってきた値を元にDBへ検索を実行
        // dd($todo);
        // dd(compact('todo'));
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
        // dd($input);
        $this->todo->find($id)->fill($input)->save();
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->todo->find($id)->delete();
        return redirect()->route('todo.index');
    }
}
