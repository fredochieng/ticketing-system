<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Issue extends Model
{
    protected $table = 'issues_categories';
    // Fetch issue categories
    public static function getIssueCategories()
    {

        $issue_categories = DB::table('issues_categories')->orderBy('issue_id', 'asc')->get();

        return $issue_categories;
    }

    // Fetch issue subcategory issue category id
    public static function getIssueSubCategories($issue_id = 0)
    {
        $issue_subcategories = DB::table('issue_subcategories')->where('issue_id', $issue_id)->get();

        return $issue_subcategories;
    }
}