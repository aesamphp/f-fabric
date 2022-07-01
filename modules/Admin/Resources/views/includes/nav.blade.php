<ul id="nav-mobile" class="side-nav fixed">
  <li class="logo no-hover">
    <a href="{{ route('admin::dashboard') }}">
      <img class="responsive-img center-block logo" src="{{ asset('images/logo.png') }}" alt="Logo"/>
    </a>
  </li>
  @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER')]))
    <li class="bold{{ isActiveRoute('admin::dashboard', ' active') }}">
      <a href="{{ route('admin::dashboard') }}">Dashboard</a>
    </li>
  @endif
  <li class="no-padding no-hover">
    <ul class="collapsible collapsible-accordion">
      @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER'), getUserRoleType('TYPE_FACTORY')]))
        <li class="bold{{ areActivePaths(['adm1n/categories', 'adm1n/category/*', 'adm1n/products', 'adm1n/product/*', 'adm1n/materials', 'adm1n/material/*', 'adm1n/designs', 'adm1n/design/*', 'adm1n/material-categories/*', 'adm1n/material-category/*'], ' active') }}">
          <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/categories', 'adm1n/category/*', 'adm1n/products', 'adm1n/product/*', 'adm1n/materials', 'adm1n/material/*', 'adm1n/designs', 'adm1n/design/*', 'adm1n/material-categories/*', 'adm1n/material-category/*'], ' active') }}">Catalog</a>
          <div class="collapsible-body">
            <ul>
              @if (areAllowed([getUserRoleType('TYPE_ADMIN')]))
                <li class="{{ areActivePaths(['adm1n/categories', 'adm1n/category/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.categories') }}">Categories</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/products', 'adm1n/product/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.products') }}">Products</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/materials', 'adm1n/material/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.materials') }}">Materials</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/material-categories', 'adm1n/material-category/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.material-categories') }}">Material Categories</a>
                </li>
              @endif
              @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER'), getUserRoleType('TYPE_FACTORY')]))
                <li class="{{ areActivePaths(['adm1n/designs', 'adm1n/design/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.designs') }}">Designs</a>
                </li>
              @endif
            </ul>
          </div>
        </li>
      @endif

      @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER'), getUserRoleType('TYPE_FACTORY')]))
        <li class="bold{{ areActivePaths(['adm1n/orders', 'adm1n/order/*', 'adm1n/commissions', 'adm1n/commission/*'], ' active') }}">
          <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/orders', 'adm1n/order/*', 'adm1n/commissions', 'adm1n/commission/*'], ' active') }}">Sales</a>
          <div class="collapsible-body">
            <ul>
              <li class="{{ areActivePaths(['adm1n/orders', 'adm1n/order/*'], 'active teal') }}">
                <a href="{{ route('admin::view.orders') }}">Orders</a>
              </li>
              <li class="{{ areActivePaths(['adm1n/commissions', 'adm1n/commission/*'], 'active teal') }}">
                <a href="{{ route('admin::view.commissions') }}">Commissions</a>
              </li>
            </ul>
          </div>
        </li>
      @endif

      @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER')]))
        <li class="bold{{ areActivePaths(['adm1n/discount-codes', 'adm1n/discount-code', 'adm1n/discount-code/*', 'adm1n/weekly-contests', 'adm1n/weekly-contest', 'adm1n/weekly-contest/*', 'adm1n/discount-codes-bulk', 'adm1n/discount-codes-bulk/*'], ' active') }}">
          <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/discount-codes', 'adm1n/discount-code', 'adm1n/discount-code/*', 'adm1n/weekly-contests', 'adm1n/weekly-contest', 'adm1n/weekly-contest/*'], ' active') }}">Promotions</a>
          <div class="collapsible-body">
            <ul>
              <li class="{{ areActivePaths(['adm1n/discount-codes', 'adm1n/discount-code', 'adm1n/discount-code/*'], 'active teal') }}">
                <a href="{{ route('admin::view.discount.codes') }}">Discount Codes</a>
              </li>
              <li class="{{ areActivePaths(['adm1n/discount-code-bulk', 'adm1n/discount-codes-bulk', 'adm1n/discount-codes-bulk/*'], 'active teal') }}">
                <a href="{{ route('admin::view.bulk.discount.codes') }}">Generate Discount Codes</a>
              </li>
              <li class="{{ areActivePaths(['adm1n/weekly-contests', 'adm1n/weekly-contest', 'adm1n/weekly-contest/*'], 'active teal') }}">
                <a href="{{ route('admin::view.weekly.contests') }}">Weekly Contests</a>
              </li>
            </ul>
          </div>
        </li>
      @endif
      @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER'), getUserRoleType('TYPE_MARKETING')]))
        <li class="bold{{ areActivePaths(['adm1n/pages', 'adm1n/page/*', 'adm1n/faqs', 'adm1n/faq', 'adm1n/faq/*', 'adm1n/design-tips', 'adm1n/design-tip', 'adm1n/design-tip/*', 'adm1n/blog/articles', 'adm1n/blog/article', 'adm1n/blog/article/*', 'adm1n/cms-products', 'adm1n/cms-product', 'adm1n/cms-product/*', 'adm1n/carousels', 'adm1n/carousel/*', 'adm1n/about-us', 'adm1n/about-us/*', 'adm1n/blocks', 'adm1n/block/*', 'adm1n/rows', 'adm1n/row/*', 'adm1n/new-row', 'adm1n/menus', 'adm1n/menu/*'], ' active') }}">
          <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/pages', 'adm1n/page/*', 'adm1n/faqs', 'adm1n/faq', 'adm1n/faq/*', 'adm1n/design-tips', 'adm1n/design-tip', 'adm1n/design-tip/*', 'adm1n/blog/articles', 'adm1n/blog/article', 'adm1n/blog/article/*', 'adm1n/cms-products', 'adm1n/cms-product', 'adm1n/cms-product/*', 'adm1n/carousels', 'adm1n/carousel/*', 'adm1n/blocks', 'adm1n/block/*', 'adm1n/rows', 'adm1n/row/*', 'adm1n/new-row', 'adm1n/menus', 'adm1n/menu/*'], ' active') }}">CMS</a>
          <div class="collapsible-body">
            <ul>
              @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER')]))
                <li class="{{ areActivePaths(['adm1n/pages', 'adm1n/page/*'], 'active teal') }}">
                  <a href="{{ route('admin::show.pages') }}">Pages</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/menus', 'adm1n/menu/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.menus') }}">Menus</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/faqs', 'adm1n/faq', 'adm1n/faq/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.faqs') }}">FAQ's</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/design-tips', 'adm1n/design-tip', 'adm1n/design-tip/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.design.tips') }}">Design Tips</a>
                </li>
              @endif
              @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER'), getUserRoleType('TYPE_MARKETING')]))
                <li class="{{ areActivePaths(['adm1n/blog/articles', 'adm1n/blog/article', 'adm1n/blog/article/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.blog.articles') }}">Blog</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/cms-products', 'adm1n/cms-product', 'adm1n/cms-product/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.cms.products') }}">Products</a>
                </li>
              @endif
              @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER')]))
                <li class="{{ areActivePaths(['adm1n/carousels', 'adm1n/carousel/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.carousels') }}">Carousels</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/about-us', 'adm1n/about-us/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.about') }}">About Us</a>
                </li>
                <li class="no-padding no-hover">
                  <ul class="collapsible collapsible-accordion">
                    <li class="bold{{ areActivePaths(['adm1n/blocks', 'adm1n/block/*', 'adm1n/rows', 'adm1n/row/*', 'adm1n/new-row'], ' active') }}">
                      <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/blocks', 'adm1n/block/*', 'adm1n/rows', 'adm1n/row/*', 'adm1n/new-row'], ' active') }}">Edit
                        Home Page</a>
                      <div class="collapsible-body collapsible-body-2">
                        <ul>
                          <li class="{{ areActivePaths(['adm1n/blocks', 'adm1n/block/*', 'adm1n/new-row'], 'active teal') }}">
                            <a href="{{ route('admin::view.blocks') }}">Blocks</a>
                          </li>
                          <li class="{{ areActivePaths(['adm1n/rows', 'adm1n/row/*'], 'active teal') }}">
                            <a href="{{ route('admin::view.rows') }}">Rows</a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
              @endif
            </ul>
          </div>
        </li>
      @endif

      @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER')]))
        <li class="bold{{ isActiveRoute('admin::view.enquiries', ' active') }}">
          <a class="push-left" href="{{ route('admin::view.enquiries') }}">Enquiries</a>
        </li>
      @endif
      @if (areAllowed([getUserRoleType('TYPE_ADMIN')]))
        <li class="bold{{ isActiveRoute('adm1n/reports/*', ' active') }}">
          <a class="collapsible-header waves-effect waves-teal{{ isActiveRoute('adm1n/reports/*', ' active') }}">Reports</a>
          <div class="collapsible-body">
            <ul>
              <li class="{{ isActiveRoute('admin::download.newsletter.subscribers', 'active teal') }}">
                <a href="{{ route('admin::download.newsletter.subscribers') }}" class="text-overflow"
                   title="Download NewsLetter Subscribers">Download NewsLetter Subscribers</a>
              </li>
            </ul>
          </div>
        </li>
      @endif
      @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER')]))
        <li class="bold{{ areActivePaths(['adm1n/contributors', 'adm1n/contributor/*', 'adm1n/managers', 'adm1n/manager/*', 'adm1n/administrators', 'adm1n/administrator', 'adm1n/administrator/*', 'adm1n/marketing', 'adm1n/marketing/*', 'adm1n/factory', 'adm1n/factory/*'], ' active') }}">
          <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/contributors', 'adm1n/contributor/*', 'adm1n/managers', 'adm1n/manager/*', 'adm1n/administrators', 'adm1n/administrator', 'adm1n/administrator/*', 'adm1n/marketing', 'adm1n/marketing/*','adm1n/factory', 'adm1n/factory/*'], ' active') }}">Users</a>
          <div class="collapsible-body">
            <ul>
              @if (areAllowed([getUserRoleType('TYPE_ADMIN'), getUserRoleType('TYPE_MANAGER')]))
                <li class="{{ areActivePaths(['adm1n/contributors', 'adm1n/contributor/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.contributors') }}">Contributers</a>
                </li>
              @endif
              @if (areAllowed([getUserRoleType('TYPE_ADMIN')]))
                <li class="{{ areActivePaths(['adm1n/managers', 'adm1n/manager/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.managers') }}">Managers</a>
                </li>
                <li class="{{ areActivePaths(['adm1n/administrators', 'adm1n/administrator', 'adm1n/administrator/*'], 'active teal') }}">
                  <a href="{{ route('admin::view.admins') }}">Administrators</a>
                </li>
              @endif
            </ul>
          </div>
        </li>
      @endif
      @if (areAllowed([getUserRoleType('TYPE_ADMIN')]))
        <li class="bold{{ areActivePaths(['adm1n/settings/*', 'adm1n/currencies', 'adm1n/currency/*'], ' active') }}">
          <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/settings/*', 'adm1n/currencies', 'adm1n/currency/*'], ' active') }}">Settings</a>
          <div class="collapsible-body">
            <ul>
              <li class="{{ isActiveRoute('admin::view.general.settings', 'active teal') }}">
                <a href="{{ route('admin::view.general.settings') }}">General</a>
              </li>
              <li class="{{ areActiveRoutes(['admin::view.notification.banners', 'admin::create.notification.banner', 'admin::view.notification.banner'], 'active teal') }}">
                <a href="{{ route('admin::view.notification.banners') }}">Notification Banner</a>
              </li>
              <li class="{{ isActiveRoute('admin::view.contact.settings', 'active teal') }}">
                <a href="{{ route('admin::view.contact.settings') }}">Contact Details</a>
              </li>
              <li class="{{ isActiveRoute('admin::view.payment.gateway.settings', 'active teal') }}">
                <a href="{{ route('admin::view.payment.gateway.settings') }}">Payment Gateway</a>
              </li>
              <li class="no-padding no-hover">
                <ul class="collapsible collapsible-accordion">
                  <li class="bold{{ areActivePaths(['adm1n/settings/shipping/*'], ' active') }}">
                    <a class="collapsible-header waves-effect waves-teal{{ areActivePaths(['adm1n/settings/shipping/*'], ' active') }}">Shipping</a>
                    <div class="collapsible-body collapsible-body-2">
                      <ul>
                        <li class="{{ isActiveRoute('admin::view.shipping.origin.address.settings', 'active teal') }}">
                          <a href="{{ route('admin::view.shipping.origin.address.settings') }}">Origin Address</a>
                        </li>
                        <li class="{{ areActivePaths(['adm1n/settings/shipping/zones', 'adm1n/settings/shipping/zone', 'adm1n/settings/shipping/zone/*'], 'active teal') }}">
                          <a href="{{ route('admin::view.shipping.zones') }}">Zones</a>
                        </li>
                        <li class="{{ areActivePaths(['adm1n/settings/shipping/package-types', 'adm1n/settings/shipping/package-type', 'adm1n/settings/shipping/package-type/*'], 'active teal') }}">
                          <a href="{{ route('admin::view.shipping.package.types') }}">Package Types</a>
                        </li>
                        <li class="{{ areActivePaths(['adm1n/settings/shipping/weight-brandings', 'adm1n/settings/shipping/weight-branding', 'adm1n/settings/shipping/weight-branding/*'], 'active teal') }}">
                          <a href="{{ route('admin::view.shipping.weight.brandings') }}">Weight Branding</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="{{ areActivePaths(['adm1n/settings/email-templates', 'adm1n/settings/email-template', 'adm1n/settings/email-template/*'], 'active teal') }}">
                <a href="{{ route('admin::view.email.templates') }}">Email Templates</a>
              </li>
              <li class="{{ areActivePaths(['adm1n/currencies', 'adm1n/currency/*'], 'active teal') }}">
                <a href="{{ route('admin::view.currencies') }}">Currency</a>
              </li>
              <li class="{{ isActiveRoute('admin::view.social.media.settings', 'active teal') }}">
                <a href="{{ route('admin::view.social.media.settings') }}">Social Media</a>
              </li>
            </ul>
          </div>
        </li>
      @endif
    </ul>
  </li>
  <li class="bold">
    <form action="{{ route('admin::logout') }}" method="POST">
      {{ csrf_field() }}
      <button class="btn-logout" type="submit">Log out ({{ getAuthenticatedUser()->first_name }})</button>
    </form>
  </li>
</ul>