<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin(Request $request)
    {
        if (isset($request->filter)) {
            
            if ($request->filter == 'incomplete') {
                
                $tasks = Task::where('completed', 0)->paginate(8);
                $filter = 'incomplete';

                return view('admin.tasks.list')->with(['tasks' => $tasks, 'filter' => $filter]);

            } else if ($request->filter == 'complete') {
                
                $tasks = Task::where('completed', 1)->paginate(8);
                $filter = 'complete';

                return view('admin.tasks.list')->with(['tasks' => $tasks, 'filter' => $filter]);

            } else {
                
                $tasks = Task::orderBy('id', 'asc')->paginate(8);
                $filter = 'all';

                return view('admin.tasks.list')->with(['tasks' => $tasks, 'filter' => $filter]);

            }

        } else {
            
            $tasks = Task::orderBy('id', 'asc')->paginate(8);
            $filter = 'all';

            return view('admin.tasks.list')->with(['tasks' => $tasks, 'filter' => $filter]);

        }

        //$tasks = Task::orderBy('id', 'asc')->paginate(8);
        
        //return view('admin.tasks.list')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if user is a staff member
        $userList = User::all();
        $allStaffArray = [];
        foreach ($userList as $user) {
            $roleCheck = $user->hasAnyRole('admin|partner-manager|support');
            
            if ($roleCheck == true) {
                array_push($allStaffArray, $user);
            }
        }

        $unassignedStaffArray = [];

        foreach ($allStaffArray as $staff) {
            array_push($unassignedStaffArray, $staff);
        }

        // Gather Creators
        $unassignedCreatorArray = [];

        foreach ($userList as $user) {

            if ($user->subscribed('influencer')) {
                array_push($unassignedCreatorArray, $user);
            }
        }
        
        $today = Carbon::now();

        return view('admin.tasks.create')->with(['unassignedStaffArray' => $unassignedStaffArray, 'unassignedCreatorArray' => $unassignedCreatorArray, 'today' => $today]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'importance' => 'required'
        ]);
        
        // Staff Array
        if (null !== ($request->input('staff'))) {
            if (count($request->input('staff')) > 1) {
                $s = implode(',', $request->input('staff'));
            } else {
                $s = implode('', $request->input('staff'));
            } 
        } else {
            $s = null;
        }

        // Creator Array
        if (null !== ($request->input('creators'))) {
            if (count($request->input('creators')) > 1) {
                $c = implode(',', $request->input('creators'));
            } else {
                $c = implode('', $request->input('creators'));
            } 
        } else {
            $c = null;
        }
        
        $task = new Task;
        $user = User::where('id', Auth::user()->id)->first();
        
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->importance = $request->input('importance');
        $task->staff = $s;
        $task->creators = $c;
        $task->completed = 0;
        $task->assigner_id = $user->id;

        if (null !== ($request->input('due_date'))) {
            $task->due_date = date_format(new DateTime($request->due_date), 'Y-m-d');
        } else {
            $task->due_date = null;
        }
        
        $task->save();

        return redirect('/admin/tasks/')->with('success', 'Task Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::where('id', $id)->first();
        $assigner = User::where('id', $task->assigner_id)->first();

        // Check if user is a staff member
        $userList = User::all();
        $allStaffArray = [];
        foreach ($userList as $user) {
            $roleCheck = $user->hasAnyRole('admin|partner-manager|support');
            
            if ($roleCheck == true) {
                array_push($allStaffArray, $user);
            }
        }

        $staffList = explode(',', $task->staff);
        $unassignedStaffArray = [];
        $staffArray = [];

        foreach ($allStaffArray as $staff) {

            if (in_array($staff->id, $staffList)) {
                array_push($staffArray, $staff);
            } else {
                array_push($unassignedStaffArray, $staff);
            }
        }

        // Gather Creators
        $creatorList = explode(',', $task->creators);
        $unassignedCreatorArray = [];
        $creatorArray = [];

        foreach ($userList as $user) {

            if ($user->subscribed('influencer')) {

                if (in_array($user->id, $creatorList)) {
                    array_push($creatorArray, $user);
                } else {
                    array_push($unassignedCreatorArray, $user);
                }
                
            }
        }

        return view('admin.tasks.show')->with(['task' => $task, 'assigner' => $assigner, 'unassignedStaffArray' => $unassignedStaffArray, 'staffArray' => $staffArray, 'unassignedCreatorArray' => $unassignedCreatorArray, 'creatorArray' => $creatorArray]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::where('id', $id)->first();
        $assigner = User::where('id', $task->assigner_id)->first();

        // Check if user is a staff member
        $userList = User::all();
        $allStaffArray = [];
        foreach ($userList as $user) {
            $roleCheck = $user->hasAnyRole('admin|partner-manager|support');
            
            if ($roleCheck == true) {
                array_push($allStaffArray, $user);
            }
        }

        $staffList = explode(',', $task->staff);
        $unassignedStaffArray = [];
        $staffArray = [];

        foreach ($allStaffArray as $staff) {

            if (in_array($staff->id, $staffList)) {
                array_push($staffArray, $staff);
            } else {
                array_push($unassignedStaffArray, $staff);
            }
        }

        // Gather Creators
        $creatorList = explode(',', $task->creators);
        $unassignedCreatorArray = [];
        $creatorArray = [];

        foreach ($userList as $user) {

            if ($user->subscribed('influencer')) {

                if (in_array($user->id, $creatorList)) {
                    array_push($creatorArray, $user);
                } else {
                    array_push($unassignedCreatorArray, $user);
                }
                
            }
        }

        return view('admin.tasks.edit')->with(['task' => $task, 'assigner' => $assigner, 'unassignedStaffArray' => $unassignedStaffArray, 'staffArray' => $staffArray, 'unassignedCreatorArray' => $unassignedCreatorArray, 'creatorArray' => $creatorArray]);
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'importance' => 'required'
        ]);

        // Staff Array
        if (null !== ($request->input('staff'))) {
            if (count($request->input('staff')) > 1) {
                $s = implode(',', $request->input('staff'));
            } else {
                $s = implode('', $request->input('staff'));
            } 
        } else {
            $s = null;
        }

        // Creator Array
        if (null !== ($request->input('creators'))) {
            if (count($request->input('creators')) > 1) {
                $c = implode(',', $request->input('creators'));
            } else {
                $c = implode('', $request->input('creators'));
            } 
        } else {
            $c = null;
        }
        
        $task = Task::where('id', $id)->first();
        
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->importance = $request->input('importance');
        $task->staff = $s;
        $task->creators = $c;

        if (null !== ($request->input('due_date'))) {
            $task->due_date = date_format(new DateTime($request->due_date), 'Y-m-d');
        } else {
            $task->due_date = null;
        }

        $task->save();

        return redirect('/admin/tasks/'.$id)->with('success', 'Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        // Redirect
        return redirect('/admin/tasks')->with('success', 'Task Deleted Successfully');
    }

    /**
     * Toggles the selected task between incomplete and complete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleComplete($id)
    {
        $task = Task::where('id', $id)->first();

        if ($task->completed == 0) {
            $task->completed = 1;
        } else {
            $task->completed = 0;
        }

        $task->save();

        return redirect('/admin/tasks/'.$id);
    }
}
