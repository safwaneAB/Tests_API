<?php
require_once('model/TestcaseModel.php');
class TestcaseController
{
    public function index($name = null)
    {
        $testcaseModel = new TestcaseModel();

        if ($name != null && isset($name))
        {
            $testcaseResult = $testcaseModel->GetTestCaseResult($name);
            return json_encode($testcaseResult);
        } 
        else 
        {
            $testcaseResults = $testcaseModel->GetAllTestCaseResults();
            return json_encode($testcaseResults);
        }
    }
}
