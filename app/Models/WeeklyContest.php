<?php

namespace App\Models;

use DB;

class WeeklyContest extends AppModel {
    
    const CSV_DESTINATION_PATH = 'downloads/weekly-contest';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'weekly_contests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'from_date', 'to_date', 'excerpt', 'description'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        $rules = $this->downloadCSVRules();
        $rules['title'] = 'required|max:255';
        $rules['excerpt'] = 'required';
        $rules['description'] = 'required';
        if ($this->scenario === 'insert') {
            $rules['from_date'] = 'required|date|after:yesterday|validateContestDates';
        }
        return $rules;
    }
    
    /**
     * Set model validation messages.
     * 
     * @return array
     */
    public function messages() {
        return [
            'from_date.validate_contest_dates' => 'The dates must not conflict with existing contest\'s dates.'
        ];
    }
    
    /**
     * Get the designs that belongs to weekly contest.
     * 
     * @return array
     */
    public function designs() {
        return $this->hasMany('App\Models\Design');
    }
    
    /**
     * Checks if the contest is live or not.
     * 
     * @return boolean
     */
    public function isLiveContest() {
        $today = date('Y-m-d');
        return $this->from_date <= $today && $today <= $this->to_date;
    }
    
    /**
     * Checks if the contest is finished or not.
     * 
     * @return boolean
     */
    public function isFinishedContest() {
        $today = date('Y-m-d');
        return $today > $this->to_date;
    }
    
    /**
     * Checks if the contest is upcoming or not.
     * 
     * @return boolean
     */
    public function isUpcomingContest() {
        return !$this->isLiveContest() && !$this->isFinishedContest();
    }
    
    /**
     * Returns the status.
     * 
     * @return string
     */
    public function getStatus() {
        $status = 'Upcoming';
        if ($this->isFinishedContest()) {
            $status = 'Finished';
        } elseif ($this->isLiveContest()) {
            $status = 'Live';
        }
        return $status;
    }
    
    /**
     * Returns the csv file destination path.
     * 
     * @return string
     */
    public function getCSVFilePath() {
        return static::CSV_DESTINATION_PATH . '/weekly_contest_' . date('dmY') . '.csv';
    }
    
    /**
     * Returns the contest random designs.
     * 
     * @param int $limit
     * @param int $offset
     * 
     * @return array
     */
    public function getRandomDesigns($limit = 0, $offset = 0) {
        $query = $this->designs()
                ->select('designs.*')
                ->join('users', 'users.id', '=', 'designs.user_id')
                ->where('designs.disabled', 0)
                ->whereNull('users.deleted_at')
                ->groupBy('designs.id')
                ->orderBy(DB::raw('RAND()'));
        if ($limit > 0) {
            $query->take($limit)
                    ->skip($offset);
        }
        return $query->get();
    }
    
    /**
     * Returns the contest popular designs.
     * 
     * @return array
     */
    public function getPopularDesigns() {
        return $this->designs()
                ->select(DB::raw('designs.*, COUNT(design_contest_likes.design_id) as likes_count'))
                ->leftJoin('design_contest_likes', 'designs.id', '=', 'design_contest_likes.design_id')
                ->where('designs.weekly_contest_id', $this->id)
                ->where('designs.disabled', 0)
                ->whereNull('design_contest_likes.deleted_at')
                ->groupBy('designs.id')
                ->orderBy('likes_count', 'DESC')
                ->get();
    }
    
    /**
     * Returns the live contest designs.
     * 
     * @param int $limit
     * 
     * @return array
     */
    public static function getLiveContestDesigns($limit = 8) {
        if (isLiveContest()) {
            return getLiveContest()->getRandomDesigns($limit);
        }
    }
    
    /**
     * Returns the live contest all designs.
     * 
     * @return array
     */
    public static function getLiveContestAllDesigns() {
        if (isLiveContest()) {
            return getLiveContest()->getRandomDesigns();
        }
    }
    
    /**
     * Checks if the dates conflicts with any existing contest or not.
     * 
     * @param date $fromDate
     * @param date $toDate
     * 
     * @return boolean
     */
    public static function validateDates($fromDate, $toDate) {
        $dates = [formatDate($fromDate, 'Y-m-d'), formatDate($toDate, 'Y-m-d')];
        $contests = static::where(function($query) use ($dates) {
                    $query->whereBetween('from_date', $dates)
                            ->orWhereBetween('to_date', $dates);
                })
                ->where('disabled', 0)
                ->get()
                ->toArray();
        return empty($contests);
    }

    /**
     * Function to perform default actions on events.
     */
    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->user_id = getAuthenticatedUser()->id;
            $model->from_date = formatDate($model->from_date, 'Y-m-d');
            $model->to_date = formatDate($model->to_date, 'Y-m-d');
        });
        static::updating(function($model) {
            $model->from_date = formatDate($model->from_date, 'Y-m-d');
            $model->to_date = formatDate($model->to_date, 'Y-m-d');
        });
    }

}
