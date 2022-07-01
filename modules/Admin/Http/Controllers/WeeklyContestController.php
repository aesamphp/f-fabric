<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeeklyContest;

class WeeklyContestController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->setModel(new WeeklyContest);
    }

    public function showWeeklyContests(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $weeklyContests = parent::getEntities($offset, [
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ], ['column' => 'created_at', 'type' => 'DESC']);
        if ($request->ajax()) {
            return view('admin::weekly-contest.weekly-contest-row', ['weeklyContests' => $weeklyContests]);
        }
        return view('admin::weekly-contest.weekly-contests', [
            'weeklyContests' => $weeklyContests,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function newWeeklyContest(Request $request) {
        return view('admin::weekly-contest.new-weekly-contest');
    }
    
    public function storeWeeklyContest(Request $request) {
        $redirect = redirect()->route('admin::new.weekly.contest');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.weekly.contests')
                ->with('status', 'Weekly contest created!');
    }
    
    public function showWeeklyContest(Request $request, $id) {
        return view('admin::weekly-contest.weekly-contest', ['weeklyContest' => parent::getEntity($id)]);
    }
    
    public function updateWeeklyContest(Request $request, $id) {
        $redirect = redirect()->route('admin::view.weekly.contest', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Weekly contest updated!');
    }
    
    public function deleteWeeklyContest(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.weekly.contests')
                ->with('status', 'Weekly contest deleted!');
    }
    
    public function downloadWeeklyContestReport(Request $request, $id) {
        $entity = parent::getEntity($id);
        $items = $this->getCSVEntities($entity);
        $fileName = $entity->getCSVFilePath();
        $handle = fopen($fileName, 'w+');
        foreach ($items as $item) {
            fputcsv($handle, $item);
        }
        fclose($handle);
        return response()->download($fileName);
    }
    
    private function getCSVEntities($entity) {
        $array = [
            ['Design ID', 'Design Title', 'Designer Name', 'Designer Email Address', '# of likes']
        ];
        foreach ($entity->getPopularDesigns() as $design) {
            $array[] = [
                'design_friendly_id' => $design->friendly_id,
                'design_title' => $design->title,
                'designer_name' => $design->user->getFullName(),
                'designer_email' => $design->user->email,
                'no_of_likes' => $design->getContestLikesCount()
            ];
        }
        return $array;
    }

}
