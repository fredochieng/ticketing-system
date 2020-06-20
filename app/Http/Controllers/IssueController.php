<?php

namespace App\Http\Controllers;

use App\Model\Issue;
use Illuminate\Http\Request;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Model\Ticket;
use Illuminate\Support\Facades\Validator;
use App\Model\IssueSubCategory;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Fetch issue categories
        $data['issueCategories'] = Issue::getIssueCategories();

        // Load index view
        return view('issues.index')->with($data);
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
        try {
            $issue = new Issue();
            $issue->issue_name = ucwords($request->input('name'));
            $issue->issue_description = $request->input('description');

            DB::beginTransaction();
            $issue->save();
            DB::commit();

            toast('Issue category added successfully', 'success', 'top-right');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            toast('Oops!!! An error ocurred while creating new issue category', 'warning', 'top-right');

            return view('issues.index');
        }
    }

    public function storeIssueSub(Request $request, $issuecategory)
    {

        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:5|max:50'
        ]);

        if ($validator->fails()) {
            DB::rollBack();

            toast('Oops!!! An error ocurred while creating new issue subcategory', 'warning', 'top-right');

            return back();
        } else {
            $issue_sub = new IssueSubCategory();
            $issue_sub->issue_id = $issuecategory;
            $issue_sub->issue_subcategory_name = ucwords($request->input('name'));

            DB::beginTransaction();
            $issue_sub->save();
            DB::commit();
            toast('Issue subcategory successfully created', 'success', 'top-right');

            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $issue)
    {
        $issue_id = $request->input('issue_id');
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:5|max:50'
        ]);

        if ($validator->fails()) {

            toast('Oops!!! An error ocurred while updating issue category', 'warning', 'top-right');
            return back();
        } else {
            $issues = Issue::where("issue_id", $issue_id)->update([
                "issue_name" => ucwords($request->name),
                'issue_description' => ucwords($request->description)
            ]);

            toast('Issue category successfully updated', 'success', 'top-right');
            return back();
        }
    }

    public function updateIssueSub(Request $request, $issuesubcategory)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:5|max:50'
        ]);

        if ($validator->fails()) {

            return back();
        } else {
            $issue_sub = IssueSubCategory::where("issue_subcategory_id", $issuesubcategory)->update([
                "issue_subcategory_name" => ucwords($request->name)
            ]);

            toast('Issue subcategory successfully updated', 'success', 'top-right');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function deleteIssueCategory(Request $request, $issue)
    {
        $issue_id = $request->input('issue_id');
        $resp = DB::table('issues_categories')->where('issue_id', $issue_id)->delete();
        if ($resp == 1) {
            Alert::success('Delete Issue Category', 'Issue category successfully deleted');
            return back();
        } else {
            Alert::error('Delete Issue Category', 'Issue category cannot be deleted');
            return redirect('issues/categories');
        }
    }

    public function deleteIssueSubcategory($issue)
    {
        $resp = DB::table('issue_subcategories')->where('issue_subcategory_id', $issue)->delete();
        if ($resp == 1) {
            Alert::success('Delete Issue Subcategory', 'Issue subcategory successfully deleted');
            return back();
        } else {
            Alert::error('Delete Issue Subcategory', 'Issue subcategory cannot be deleted');
            return back();
        }
    }

    public function manageIssues($issue_id = null)
    {
        $data['issueSubCategories'] = DB::table('issue_subcategories')
            ->select(
                DB::raw('issue_subcategories.*'),
                DB::raw('issues_categories.*')
            )
            ->leftjoin('issues_categories', 'issue_subcategories.issue_id', 'issues_categories.issue_id')
            ->where('issue_subcategories.issue_id', '=', $issue_id)->get();

        if ($data['issueSubCategories']) {
        }

        $data['issue_cat'] = DB::table('issues_categories')->where('issues_categories.issue_id', '=', $issue_id)->first();

        $data['issue_name'] =  $data['issue_cat']->issue_name;
        $data['issue_id'] =  $data['issue_cat']->issue_id;


        return view('issues.subs')->with($data);
    }

    public function sub_categories($id)
    {

        $data['issueCategories'] = Issue::getIssueCategories();
        $data['issueCategorySelected'] = DB::table('issues_categories')->select(DB::raw('issues_categories.*'))->where('issue_id', '=', $id)->first();
        // $data['issueSubCategories'] = Issue::where( 'issue_id', '=' , $id );
        $data['issueSubCategories'] = DB::table('issue_subcategories')->select(DB::raw('issue_subcategories.*'))->where('issue_id', '=', $id)->get();

        return view('issues.sub_categories')->with($data);;
    }
}
