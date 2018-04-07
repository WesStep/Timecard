<?php

namespace App\Http\Controllers;

use App\Company;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function addCompany(Request $request)
    {
        // Validate the company name
        $validatedData = $request->validate([
           'newCompany' => 'string|max:100|unique:companies,name'
        ]);
        $company = new Company([
            'name' => $request->input('newCompany'),
            'is_deleted' => false
        ]);
        $company->save();
        return redirect()->back()->with('info', 'Company Added!');
    }

    public function deleteCompany(Request $request)
    {
        // Validate the company name
        $validatedData = $request->validate([
            'companyToDelete' => 'string|max:100|exists:companies,name'
        ]);

        // If it passes, then set the 'is_deleted' status to true. This will effectively remove it from the UI.
        DB::table('companies')
            ->where('name', $request->input('companyToDelete'))
            ->update(['is_deleted' => true]);

        return redirect()->back()->with('info', 'Company Deleted!');
    }

    public function editCompany(Request $request)
    {
        // Validate the company name
       $this->validate($request, [
           'companyName' => 'string|max:100|unique:companies,name'
        ]);

        DB::table('companies')
            ->where('id', $request->input('companyToEdit'))
            ->update(['name' => $request->input('companyName')]);
        return redirect()->back()->with('info', 'Company Edited!');
    }
}
