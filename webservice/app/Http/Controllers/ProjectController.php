<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\Task;
use App\UsersProject;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = project::with('users')->paginate(4);
        //$users = $project->users;
        return $project;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new project;
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->due_date = $request->input('due_date');
        $project->done = $request->input('done');
        $project->save();

        $UsersProjects = new UsersProject;
        $UsersProjects->user_id = auth()->user()->id;
        $UsersProjects->project_id = $project->id;
        $UsersProjects->type_user = 'Gerente';
        $UsersProjects->save();

       // $userDono = User::find($id);
       // $project = $userDono->projects()->paginate(4);
    
        return response()->json($project, 201);
    }

    public function addmember($id, Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', 'like', '%'.$email.'%')->first();
        $member = new UsersProject;
        $member->project_id = $id;
        $member->user_id =$user->id;
        $member->type_user = $request->input('type_user');
        $member->save();

        return response()->json($member, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $userDono = User::find($id);
        if($userDono){
            $project = $userDono->projects()->where('done', '=', '0')->orderBy('id', 'DESC')->paginate(50);
            return response()->json($project, 201);
        } 
    }
    
    public function tasks($id)
    {
        $AuthUser = auth()->user()->id;
        $userDono = User::find($AuthUser);
        $projectUser =  $userDono->projects()->where('user_id', '=', $AuthUser)->find($id);

        if(!$projectUser){
            return response()->json(['error' => 'Not found'], 404);
        }else{
            $users = $projectUser->users()->get();
            $tasks = $projectUser->tasks()
            ->orderBy('risk', 'DESC')
            ->orderBy('runtime', 'DESC')
            ->orderBy('value_client', 'DESC')
            ->get();
            return response()->json([
                'project' => $projectUser,
                'tasks' => $tasks,
                'users' => $users,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
            $ProjectOn = Project::find($id);
            $ProjectOn->done = 1;
            $ProjectOn->save();

        return response()->json($ProjectOn, 201);
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
    }
}
