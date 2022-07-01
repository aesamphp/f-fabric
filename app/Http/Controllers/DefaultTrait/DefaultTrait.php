<?php

namespace App\Http\Controllers\DefaultTrait;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Enquiry;
use App\Models\Community;
use App\Models\User;
use App\Models\BlogArticle;
use App\Models\DesignTipCategory;
use App\Models\Studio;
use App\Models\ReportedComment;
use App\Models\FaqCategory;
use App\Models\Design;
use App\Models\DesignLabel;
use App\Services\PCAPredictService;
use Validator;

trait DefaultTrait {
    
    public function joinCommunity(Request $request) {
        $this->setModel(new Community);
        $redirect = redirect()->route('view.community');
        $user = User::where('email', $request->input('email'))->first();
        if ($user === null) {
            parent::storeEntity($request->all(), $redirect);
            return $redirect->with('status', 'Thank you for joining our community.');
        }
        return $redirect->with('error', 'The email has already been taken.');
    }
    
    public function submitContact(Request $request) {
        $this->setModel(new Enquiry);
        $redirect = redirect()->route('view.contact');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        $this->sendContactEmails($entity);
        return $redirect->with('status', 'Thank you for contacting us. We will respond to you as soon as possible.');
    }
    
    public function changeCurrency(Request $request) {
        $validator = Validator::make($request->all(), ['currency' => 'required|integer']);
        if ($validator->fails()) {
            abort(Response::HTTP_BAD_REQUEST, 'The currency field is required.');
        }
        session()->put('currencyID', $request->input('currency'));
        return redirect()->back();
    }
    
    public function searchTags(Request $request) {
        $keyword = '%' . $request->input('search_tags') . '%';
        return view('includes.tags-list', [
            'filterLabels' => [],
            'listType' => $request->get('list_type'),
            'labelCollection' => DesignLabel::searchPopularLabels($keyword)
        ]);
    }
    
    public function searchDesignsByTag(Request $request, $tag) {
        return view('default.label-designs', [
            'labelKeyword' => $tag,
            'labelDesigns' => Design::getDesignsByLabel($tag),
        ]);
    }
    
    public function reportComment(Request $request, $id) {
        $this->setModel(new ReportedComment);
        $redirect = redirect()->back();
        $request->merge(['comment_id' => $id]);
        parent::storeEntity($request->all(), $redirect);
        return $redirect->with('status', 'Comment reported successfully!');
    }
    
    public function downloadFile(Request $request) {
        return response()->download(public_path($request->get('path')));
    }
    
    public function searchAddress(Request $request) {
        $pcaService = new PCAPredictService($request->input('address'));
        return response()->json($pcaService->MakeRequest());
    }

    private function getPageLinks() {
        $links = [];
        $routes = ['home', 'view.how.it.works', 'view.contribute', 'view.community', 'view.contact', 'view.about', 'view.delivery.and.returns', 'view.terms.and.conditions', 'view.privacy', 'view.custom.printing', 'view.products', 'view.design.create', 'view.design.upload', 'view.shop', 'view.shop.all', 'view.shop.colour.atlas', 'view.shop.sample.books', 'view.shop.plain.fabrics', 'view.login', 'search'];
        foreach ($routes as $route) {
            $links[] = route($route);
        }
        return $links;
    }

    private function getBlogLinks() {
        $links = [route('view.blog')];
        $this->setModel(new BlogArticle);
        $articles = parent::getAllEntities([
            ['column' => 'active', 'condition' => '=', 'value' => 1]
        ]);
        foreach ($articles as $article) {
            $links[] = route('view.blog.article', ['identifier' => $article->identifier]);
        }
        return $links;
    }

    private function getFaqLinks() {
        $links = [route('view.faqs')];
        $this->setModel(new FaqCategory);
        $categories = parent::getAllEntities();
        foreach ($categories as $category) {
            $links[] = route('view.faqs.category', ['identifier' => $category->identifier]);
        }
        return $links;
    }

    private function getDesignTipLinks() {
        $links = [route('view.design.tips')];
        $this->setModel(new DesignTipCategory);
        $categories = parent::getAllEntities();
        foreach ($categories as $category) {
            $links[] = route('view.design.tips.category', ['category' => $category->identifier]);
            foreach ($category->designTips as $designTip) {
                $links[] = route('view.design.tip', ['category' => $category->identifier, 'identifier' => $designTip->identifier]);
            }
        }
        return $links;
    }

    private function getDesignLinks() {
        $links = [];
        $this->setModel(new Design);
        $designs = parent::getAllEntities([
            ['column' => 'swatch_purchased', 'condition' => '=', 'value' => 1],
            ['column' => 'public', 'condition' => '=', 'value' => 1],
            ['column' => 'approved', 'condition' => '=', 'value' => 1],
            ['column' => 'dispatch_approved', 'condition' => '=', 'value' => 1],
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);
        foreach ($designs as $design) {
            $links[] = route('view.shop.design', ['identifier' => $design->identifier]);
        }
        return $links;
    }

    private function getStoreLinks() {
        $links = [];
        $this->setModel(new Studio);
        $stores = parent::getAllEntities([
            ['column' => 'public', 'condition' => '=', 'value' => 1],
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);
        foreach ($stores as $store) {
            $links[] = route('view.designer.store', ['username' => $store->username]);
        }
        return $links;
    }

    private function sendContactEmails($entity) {
        parent::sendEmail('emails.contact', ['enquiry' => $entity], [
            'from_email' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to_email' => $entity->email,
            'to_name' => $entity->name,
            'subject' => 'Contact Fashion Formula'
        ]);
        parent::sendEmail('emails.contact-admin', ['enquiry' => $entity], [
            'from_email' => $entity->email,
            'from_name' => $entity->name,
            'to_email' => getSettingValue('contact/email'),
            'to_name' => config('mail.from.name'),
            'subject' => $entity->subject
        ]);
    }

}
