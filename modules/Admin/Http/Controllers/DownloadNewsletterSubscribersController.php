<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadNewsletterSubscribersController extends Controller
{
    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function index(Request $request)
    {
        $items = array_merge([
            [
                'Name',
                'Email Address',
                'Registered',
                'Registered Date',
            ],
        ],
            $this->getCommunityCSVEntities(),
            $this->getUserNewsLetterCSVEntities()
        );

        $fileName = 'downloads/newsletter-subscribers/newsletter_subscribers_' . date('dmY') . '.csv';
        $handle = fopen($fileName, 'w+');
        foreach ($items as $item) {
            fputcsv($handle, $item);
        }
        fclose($handle);
        return response()->download($fileName);
    }

    /**
     * @return array
     */
    private function getCommunityCSVEntities()
    {
        $array = [];
        $entities = Community::all();

        foreach ($entities as $entity) {
            $array[] = [
                'name' => 'N/A',
                'email' => $entity->email,
                'registered' => 'No',
                'registered_date' => null
            ];
        }

        return $array;
    }

    /**
     * @return array
     */
    private function getUserNewsLetterCSVEntities()
    {
        $array = [];
        $entities = User::where('role_id', UserRole::TYPE_CONTRIBUTOR)
            ->where('newsletter_email', 1)
            ->get();

        foreach ($entities as $entity) {
            $array[] = [
                'name' => $entity->getFullName(),
                'email' => $entity->email,
                'registered' => 'Yes',
                'registered_date' => $entity->subscribed_at,
            ];
        }

        return $array;
    }
}
