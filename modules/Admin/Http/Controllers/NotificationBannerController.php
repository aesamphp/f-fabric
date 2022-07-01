<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationBannerStoreRequest;
use App\Models\NotificationBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationBannerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new NotificationBanner);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $offset = $request->has('offset') ?: 0;
        $notificationBanners = parent::getEntities($offset);

        if ($request->ajax()) {
            return view('admin::setting.settings-notification-banner', compact('notificationBanners'));
        }

        return view('admin::setting.settings-notification-banner', [
            'notificationBanners' => $notificationBanners,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount(),
        ]);
    }

    /**
     * @param NotificationBanner $notificationBanner
     * @return View
     */
    public function show(NotificationBanner $notificationBanner)
    {
        return view('admin::setting.notification-banner', compact('notificationBanner'));
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('admin::setting.notification-banner');
    }

    /**
     * @param NotificationBannerStoreRequest $request
     * @return array|RedirectResponse
     */
    public function store(NotificationBannerStoreRequest $request)
    {
        $redirect = redirect()->route('admin::create.notification.banner');
        $notificationBanner = parent::storeEntity($request->all(), $redirect);

        if (!isset($notificationBanner->id)) {
            return $notificationBanner;
        }

        return redirect()->route('admin::view.notification.banner', ['id' => $notificationBanner->id])
            ->withStatus('Notification banner created!');
    }

    /**
     * @param NotificationBanner $notificationBanner
     * @return RedirectResponse
     */
    public function destroy(NotificationBanner $notificationBanner)
    {
        $notificationBanner->delete();

        return redirect()->route('admin::view.notification.banners')
            ->withStatus('Notification banner deleted!');
    }

    /**
     * @param NotificationBanner $notificationBanner
     * @param NotificationBannerStoreRequest $request
     * @return RedirectResponse
     */
    public function edit(NotificationBanner $notificationBanner, NotificationBannerStoreRequest $request)
    {
        $notificationBanner->update($request->all());

        return redirect()->route('admin::view.notification.banner', ['id' => $notificationBanner->id])
            ->withStatus('Notification banner updated!');
    }
}