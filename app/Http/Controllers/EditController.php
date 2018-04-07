<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

    /*
     *  At the beginning of each function is a line explaining what each function
     *  does along with which type of user roles have access to each function.
     */

class EditController extends Controller
{
    public function editInfo(Request $request)
    {
        // Process edit account info page [employee, payroll admin, business owner]
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|min:2|max:250|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ]
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        // Separate first and last names
        $userName = explode(' ', $user->name);
        // Select just the first name
        $userFirstName = $userName[0];
        return redirect()->route('dashboard/edit', ['userFirstName' => $userFirstName])->with('info', 'Account Edited!');
    }

    public function payrollEditAccount(Request $request)
    {
        
    }

    public function deleteAccount()
    {
        // Process delete account page [payroll admin, business owner]
        return redirect()->back()->with('info', 'Account Deleted!');
    }
}
