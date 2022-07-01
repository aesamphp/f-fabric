<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayOption;
use App\Models\EmailTemplateAction;
use App\Models\EmailTemplate;
use App\Models\Currency;

class SettingController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new Setting);
    }

    public function showGeneralSettings(Request $request) {
        return view('admin::setting.settings-general', [
            'settings' => parent::getAllEntities([
                ['column' => 'path', 'condition' => 'like', 'value' => 'general%']
            ])
        ]);
    }
    
    public function updateGeneralSettings(Request $request) {
        $redirect = redirect()->route('admin::view.general.settings');
        $this->updateSettings($request->settings, $redirect);
        return $redirect->with('status', 'Settings updated!');
    }
    
    public function showContactSettings(Request $request) {
        return view('admin::setting.settings-contact', [
            'settings' => parent::getAllEntities([
                ['column' => 'path', 'condition' => 'like', 'value' => 'contact%']
            ])
        ]);
    }
    
    public function updateContactSettings(Request $request) {
        $redirect = redirect()->route('admin::view.contact.settings');
        $this->updateSettings($request->settings, $redirect);
        return $redirect->with('status', 'Settings updated!');
    }
    
    public function showPaymentGatewaySettings(Request $request) {
        $this->setModel(new PaymentGateway);
        return view('admin::setting.settings-payment-gateway', [
            'gateways' => parent::getAllEntities()
        ]);
    }
    
    public function updatePaymentGatewaySettings(Request $request) {
        $this->setModel(new PaymentGateway);
        $redirect = redirect()->route('admin::view.payment.gateway.settings');
        foreach ($request->gateway as $key => $value) {
            $entity = parent::getEntity($key);
            parent::updateEntity($value, $entity->id, $redirect);
        }
        $this->setModel(new PaymentGatewayOption);
        $this->updateSettings($request->settings, $redirect);
        return $redirect->with('status', 'Settings updated!');
    }
    
    public function showShippingOriginAddressSettings(Request $request) {
        return view('admin::setting.settings-shipping-origin-address', [
            'settings' => parent::getAllEntities([
                ['column' => 'path', 'condition' => 'like', 'value' => 'shipping/origin_address%']
            ])
        ]);
    }
    
    public function updateShippingOriginAddressSettings(Request $request) {
        $redirect = redirect()->route('admin::view.shipping.origin.address.settings');
        $this->updateSettings($request->settings, $redirect);
        return $redirect->with('status', 'Settings updated!');
    }
    
    public function showEmailTemplates(Request $request) {
        $this->setModel(new EmailTemplate);
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $templates = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::setting.email-template-row', ['templates' => $templates]);
        }
        return view('admin::setting.email-templates', [
            'templates' => $templates,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function showEmailTemplate(Request $request, $id) {
        $this->setModel(new EmailTemplate);
        return view('admin::setting.email-template', [
            'actions' => EmailTemplateAction::all(),
            'template' => parent::getEntity($id)
        ]);
    }
    
    public function updateEmailTemplate(Request $request, $id) {
        $this->setModel(new EmailTemplate);
        $redirect = redirect()->route('admin::view.email.template', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Email templated updated!');
    }
    
    public function newEmailTemplate(Request $request) {
        $this->setModel(new EmailTemplate);
        return view('admin::setting.new-email-template', [
            'actions' => EmailTemplateAction::has('template', '=', 0)->get()
        ]);
    }
    
    public function storeEmailTemplate(Request $request) {
        $this->setModel(new EmailTemplate);
        $redirect = redirect()->route('admin::new.email.template');
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.email.template', ['id' => $entity->id])
                ->with('status', 'Email templated created!');
    }
    
    public function deleteEmailTemplate(Request $request, $id) {
        $this->setModel(new EmailTemplate);
        parent::deleteEntity($id);
        return redirect()->route('admin::view.email.templates')
                ->with('status', 'Email templated deleted!');
    }
    
    public function showSocialMediaSettings(Request $request) {
        return view('admin::setting.settings-social-media', [
            'settings' => parent::getAllEntities([
                ['column' => 'path', 'condition' => 'like', 'value' => 'social_media%']
            ])
        ]);
    }
    
    public function updateSocialMediaSettings(Request $request) {
        $redirect = redirect()->route('admin::view.social.media.settings');
        $this->updateSettings($request->settings, $redirect);
        return $redirect->with('status', 'Settings updated!');
    }
    
    public function showCurrencies(Request $request) {
        $this->setModel(new Currency);
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $currencies = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::setting.currency-row', ['currencies' => $currencies]);
        }
        return view('admin::setting.currencies', [
            'currencies' => $currencies,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function showCurrency(Request $request, $id) {
        $this->setModel(new Currency);
        return view('admin::setting.currency', ['currency' => parent::getEntity($id)]);
    }
    
    public function updateCurrency(Request $request, $id) {
        $this->setModel(new Currency);
        $redirect = redirect()->route('admin::view.currency', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Currency updated!');
    }
    
    protected function updateSettings($settings, $redirect) {
        foreach ($settings as $key => $value) {
            $entity = parent::getEntityByFields([
                ['column' => 'path', 'condition' => '=', 'value' => $key]
            ]);
            parent::updateEntity(['value' => $value], $entity->id, $redirect);
        }
    }

}
