<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\DefaultTrait\DefaultTrait;
use App\Models\About;
use App\Models\Block;
use App\Models\CarouselSlide;
use App\Models\Category;
use App\Models\Design;
use App\Models\DesignLabel;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Page;
use App\Models\Row;
use App\Models\Studio;
use App\Models\WeeklyContest;
use App\Models\Menu;
use Illuminate\Http\Request;

/**
 * Class DefaultController
 * @package App\Http\Controllers
 */
class DefaultController extends Controller
{
    use DefaultTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('default.index', [
            'threeBlockSegment' => Block::whereDisplayType(1)->limit(3)->get(),
            'fiveBlockSegment' => Block::whereDisplayType(2)->limit(5)->get(),
            'userProfileCarousel' => Block::whereDisplayType(3)->limit(5)->get(),
            'carouselSlides' => CarouselSlide::getSlides(1)->sortBy('sort'),
            'labelCollection' => DesignLabel::getPopularLabels(),
            'labelKeyword' => null,
            'rows' => Row::getRows(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function home()
    {
        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showConfirmation()
    {
        return view('default.confirmation');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showHowItWorks()
    {
        return view('default.how-it-works');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showContribute()
    {
        return view('default.contribute');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCommunity()
    {
return redirect('blog');
        return view('default.community', [
            'liveContest' => getLiveContest(),
            'contestDesigns' => WeeklyContest::getLiveContestDesigns(),
            'upcomingContests' => getUpcomingContests(),
            'tweets' => getTweets()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showWeeklyContest()
    {
        return view('default.weekly-contest', [
            'liveContest' => getLiveContest(),
            'contestDesigns' => WeeklyContest::getLiveContestAllDesigns()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showContact()
    {
        return view('default.contact');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAbout()
    {
        $this->setModel(new About);
        return view('default.about', ["aboutUs" => parent::getEntity(1)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRefer()
    {
        return view('default.refer');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDeliveryReturns()
    {
        $this->setModel(new Page);
        return view('default.delivery-and-returns', ['page' => parent::getEntityByIdentifier('delivery-returns')]);
    }

    /**
     * @param null $identifier
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFaqs($identifier = null)
    {
        $this->setModel(new FaqCategory);
        if ($identifier === null) {
            $category = parent::getEntityByFields();
        } else {
            $category = parent::getEntityByIdentifier($identifier);
        }
        return view('default.faqs', [
            'categories' => parent::getAllEntities(),
            'category' => $category
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function searchFaqs(Request $request)
    {
        if (!$request->has('keyword')) {
            return redirect()->route('view.faqs');
        }
        $this->setModel(new FaqCategory);
        $keyword = '%' . $request->input('keyword') . '%';
        return view('default.faqs-search', [
            'keyword' => $request->input('keyword'),
            'categories' => parent::getAllEntities(),
            'faqs' => Faq::searchFaqs($keyword)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTermsConditions()
    {
        $this->setModel(new Page);
        return view('default.terms-and-conditions', ['page' => parent::getEntityByIdentifier('terms-conditions')]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPrivacy()
    {
        $this->setModel(new Page);
        return view('default.privacy', ['page' => parent::getEntityByIdentifier('privacy')]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomPrinting()
    {
        return view('default.custom-printing', [
            'latestDesigns' => Design::getLatestDesigns(8)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProducts()
    {
        return view('default.products', ['categories' => Category::getShoppableCategories()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        if (!$request->has('search_keyword')) {
            return redirect()->back();
        }

        $keyword = '%' . $request->get('search_keyword') . '%';

        return view('default.search', [
            'keyword' => $request->get('search_keyword'),
            'designs' => Design::searchDesigns($keyword),
            "users" => Studio::getUsersFromName($keyword)
        ]);
    }

    /**
     * @return mixed
     */
    public function showSitemap()
    {
        $sitemap = App::make("sitemap");
        $links   = array_merge($this->getPageLinks(), $this->getBlogLinks(), $this->getFaqLinks(), $this->getDesignTipLinks(), $this->getDesignLinks(), $this->getStoreLinks());
        foreach ($links as $link) {
            $sitemap->add($link);
        }
        return $sitemap->render('xml');
    }
}
