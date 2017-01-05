<?

// Configure application routes.

$router->request('/', 'index');

// contact form

$router->request('/contact', 'contact');
$router->request('/contact/:slug', 'contact');

// robots

$router->get('/robots.txt', function () {

	header('Content-Type: text/plain');

	if(defined('DEBUG') && DEBUG) {
		return <<<'EOF'
User-agent: *
Disallow: /
EOF;
	} else {
		return <<<'EOF'
User-agent: *
Disallow: /admin/
EOF;
	}

});

// sitemap

$router->get('/sitemap.xml', 'sitemap');
$router->get('/sitemap', 'sitemap-page');
$router->get('/sitemap/', 'sitemap-page');

// Auth

$router->request('/auth/login', 'auth/login');
$router->request('/auth/login/', 'auth/login');

$router->request('/auth/register', 'auth/register');
$router->request('/auth/register/', 'auth/register');
$router->request('/auth/register/:id', 'auth/register');

$router->request('/auth/new-register', 'auth/register-new');
$router->request('/auth/new-register/', 'auth/register-new');
$router->request('/auth/new-register/:id', 'auth/register-new');

$router->request('/auth/subscribe/:typeID', 'auth/subscribe');
$router->request('/auth/subscribe-completes', 'auth/subscribe');

$router->request('/pricing', 'pricing');

$router->filter('filter/guest', function () use ($router) {

	$router->request('/auth/password', 'auth/password');
	$router->request('/auth/password/', 'auth/password');
	$router->request('/auth/password/:q/:id', 'auth/password-reset');

});

// GoCardless Webhooks
$router->request('/webhooks', 'webhooks');

$router->filter('filter/signed-in', function () use ($router) {

	$router->request('/auth/complete', 'auth/complete');
	$router->request('/auth/complete/', 'auth/complete');

	// maintenance Mode
	$router->request('/dashboard/maintenance', 'dashboard/maintenance');
	$router->request('/dashboard/maintenance/', 'dashboard/maintenance');

	// Check maintenance mode isn't on
	$router->filter('filter/maintenance-mode', function () use ($router) {

		$router->request('/dashboard/profile', 'dashboard/profile');
		$router->request('/dashboard/profile/', 'dashboard/profile');
		$router->request('/dashboard/help', 'dashboard/help');
		$router->request('/dashboard/help/', 'dashboard/help');
		$router->request('/dashboard/complete-subscription', 'dashboard/complete-subscription');
		$router->request('/dashboard/complete-subscription/', 'dashboard/complete-subscription');

		// Check the user is subscribed
		$router->filter('filter/signed-in-subscribed', function () use ($router) {

			// Check the user is an agent admin
			$router->filter('filter/agent-admin', function () use ($router) {

				$router->request('/dashboard/staff', 'dashboard/staff');
				$router->request('/dashboard/staff/', 'dashboard/staff');
				$router->request('/dashboard/staff/search/:searchQuery', 'dashboard/staff');
				$router->request('/dashboard/staff/search/:searchQuery/', 'dashboard/staff');
				$router->request('/dashboard/staff/add', 'dashboard/staff-add');
				$router->request('/dashboard/staff/add/', 'dashboard/staff-add');
				$router->request('/dashboard/staff/edit/:id', 'dashboard/staff-edit');
				$router->request('/dashboard/staff/edit/:id/', 'dashboard/staff-edit');
				$router->request('/dashboard/staff/delete/:id', 'dashboard/staff-delete');
				$router->request('/dashboard/staff/delete/:id/', 'dashboard/staff-delete');

			});

			// randoms
			$router->request('/dashboard', 'dashboard/index');
			$router->request('/dashboard/', 'dashboard/index');
			$router->request('/dashboard/orders', 'dashboard/orders');
			$router->request('/dashboard/orders/', 'dashboard/orders');
			$router->request('/dashboard/orders/:orderID', 'dashboard/order');
			$router->request('/dashboard/orders/:orderID/', 'dashboard/order');
			$router->request('/dashboard/edit', 'dashboard/edit');
			$router->request('/dashboard/edit/', 'dashboard/edit');

			// Unsubscribe
			$router->request('/dashboard/profile/unsubscribe', 'dashboard/unsubscribe');
			$router->request('/dashboard/profile/unsubscribe/', 'dashboard/unsubscribe');

			// Chains
			$router->request('/dashboard/chains', 'dashboard/chains');
			$router->request('/dashboard/chains/', 'dashboard/chains');
			$router->request('/dashboard/chains/search/:chainID', 'dashboard/chains');
			$router->request('/dashboard/chains/search/:chainID/', 'dashboard/chains');
			$router->request('/dashboard/chains/add', 'dashboard/chain-add');
			$router->request('/dashboard/chains/add/', 'dashboard/chain-add');
			$router->request('/dashboard/chains/create', 'dashboard/chain-create');
			$router->request('/dashboard/chains/create/', 'dashboard/chain-create');
			$router->request('/dashboard/chains/:chainID', 'dashboard/chain-single');
			$router->request('/dashboard/chains/:chainID/', 'dashboard/chain-single');
			$router->request('/dashboard/chains/delete/:chainID', 'dashboard/chain-delete');
			$router->request('/dashboard/chains/delete/:chainID/', 'dashboard/chain-delete');
			$router->request('/dashboard/chains/unlink/:chainID/:keepSteps', 'dashboard/chain-unlink');
			// Link Chains
			$router->request('/dashboard/link-chains', 'dashboard/link-chains');
			$router->request('/dashboard/link-chains/', 'dashboard/link-chains');
			$router->request('/dashboard/link-chains/:chainID', 'dashboard/link-chains');
			$router->request('/dashboard/link-chains/:chainID/', 'dashboard/link-chains');
			// Properties
			$router->request('/dashboard/properties', 'dashboard/properties');
			$router->request('/dashboard/properties/', 'dashboard/properties');
			$router->request('/dashboard/properties/search/:searchQuery', 'dashboard/properties');
			$router->request('/dashboard/properties/search/:searchQuery/', 'dashboard/properties');
			$router->request('/dashboard/properties/add', 'dashboard/property-add');
			$router->request('/dashboard/properties/add/', 'dashboard/property-add');
			$router->request('/dashboard/properties/add/direct/:go_chain/:vendorID/:buyerID', 'dashboard/property-add');
			$router->request('/dashboard/properties/add/direct/:go_chain/:vendorID/:buyerID/', 'dashboard/property-add');
			$router->request('/dashboard/properties/add/:chainID', 'dashboard/property-add');
			$router->request('/dashboard/properties/add/:chainID/', 'dashboard/property-add');
			$router->request('/dashboard/properties/add/:chainID/:position', 'dashboard/property-add-new');
			$router->request('/dashboard/properties/add/:chainID/:position/', 'dashboard/property-add-new');
			$router->request('/dashboard/properties/delete/:propertyID', 'dashboard/property-delete');
			$router->request('/dashboard/properties/delete/:propertyID/', 'dashboard/property-delete');
			$router->request('/dashboard/properties/edit/:propertyID', 'dashboard/property-edit');
			$router->request('/dashboard/properties/edit/:propertyID/', 'dashboard/property-edit');
			// Buyers
			$router->request('/dashboard/buyers', 'dashboard/buyers');
			$router->request('/dashboard/buyers/', 'dashboard/buyers');
			$router->request('/dashboard/buyers/search/:searchQuery', 'dashboard/buyers');
			$router->request('/dashboard/buyers/search/:searchQuery/', 'dashboard/buyers');
			$router->request('/dashboard/buyers/add', 'dashboard/buyers-add');
			$router->request('/dashboard/buyers/add/', 'dashboard/buyers-add');
			$router->request('/dashboard/buyers/add/:go_prop/:vendorID', 'dashboard/buyers-add');
			$router->request('/dashboard/buyers/add/:go_prop/:vendorID/', 'dashboard/buyers-add');
			$router->request('/dashboard/buyers/delete/:buyerID', 'dashboard/buyers-delete');
			$router->request('/dashboard/buyers/delete/:buyerID/', 'dashboard/buyers-delete');
			$router->request('/dashboard/buyers/edit/:buyerID', 'dashboard/buyers-edit');
			$router->request('/dashboard/buyers/edit/:buyerID/', 'dashboard/buyers-edit');
			// Vendors
			$router->request('/dashboard/users', 'dashboard/users');
			$router->request('/dashboard/users/', 'dashboard/users');
			$router->request('/dashboard/users/search/:searchQuery', 'dashboard/users');
			$router->request('/dashboard/users/search/:searchQuery/', 'dashboard/users');
			$router->request('/dashboard/users/add', 'dashboard/users-add');
			$router->request('/dashboard/users/add/', 'dashboard/users-add');
			$router->request('/dashboard/users/request/:id', 'dashboard/users-request');
			$router->request('/dashboard/users/request/:id/', 'dashboard/users-request');
			$router->request('/dashboard/users/delete/:vendorID', 'dashboard/users-delete');
			$router->request('/dashboard/users/delete/:vendorID/', 'dashboard/users-delete');
			$router->request('/dashboard/users/edit/:vendorID', 'dashboard/users-edit');
			$router->request('/dashboard/users/edit/:vendorID/', 'dashboard/users-edit');
			$router->request('/dashboard/users/accept/:request_key', 'dashboard/users-accept');
			$router->request('/dashboard/users/accept/:request_key/', 'dashboard/users-accept');

			// $router->request('/dashboard/vendors/add/:go_buyer', 'dashboard/vendors-add');
			// $router->request('/dashboard/vendors/add/:go_buyer', 'dashboard/vendors-add');
			// $router->request('/dashboard/vendors/request/:id', 'dashboard/vendors-request');
			// $router->request('/dashboard/vendors/request/:id/', 'dashboard/vendors-request');
			// $router->request('/dashboard/vendors/accept/:request_key', 'dashboard/vendors-accept');
			// $router->request('/dashboard/vendors/accept/:request_key/', 'dashboard/vendors-accept');
			// $router->request('/dashboard/vendors/search/:searchQuery', 'dashboard/vendors');
			// $router->request('/dashboard/vendors/search/:searchQuery/', 'dashboard/vendors');
			// $router->request('/dashboard/vendors/delete/:vendorID', 'dashboard/vendors-delete');
			// $router->request('/dashboard/vendors/delete/:vendorID/', 'dashboard/vendors-delete');
			// $router->request('/dashboard/vendors/edit/:vendorID', 'dashboard/vendors-edit');
			// $router->request('/dashboard/vendors/edit/:vendorID/', 'dashboard/vendors-edit');
			// Inbox
			$router->request('/dashboard/inbox', 'dashboard/inbox');
			$router->request('/dashboard/inbox/', 'dashboard/inbox');
			$router->request('/dashboard/inbox/view/:messageID', 'dashboard/inbox-message');
			$router->request('/dashboard/inbox/view/:messageID/', 'dashboard/inbox-message');
			$router->request('/dashboard/inbox/compose', 'dashboard/inbox-compose');
			$router->request('/dashboard/inbox/compose/', 'dashboard/inbox-compose');

		}); // end filter

	}); // end filter

	// subscription pages
	$router->request('/dashboard/subscription/:type', 'dashboard/subscription');
	$router->request('/dashboard/subscription/:type/', 'dashboard/subscription');

	$router->post('/auth/password-change', 'auth/password-change');
	$router->post('/auth/password-change/', 'auth/password-change');

});

// content

$router->get('/:id', 'page')->where('id', '\\d+');
$router->get('/:id-:name', 'page')->where('id', '\\d+');

// Blog page
$router->get('/blog', 'blog');
$router->get('/blog/', 'blog');
$router->get('/blog/:slug', 'blog');
$router->get('/blog/:slug/', 'blog');

$router->get('/blog/all', 'articles');
$router->get('/blog/all/', 'articles');
$router->get('/blog/category/:slug', 'articles');
$router->get('/blog/category/:slug/', 'articles');
$router->get('/blog/archive/:year', 'articles');
$router->get('/blog/archive/:year/', 'articles');
$router->get('/blog/archive/:year/:month', 'articles');
$router->get('/blog/archive/:year/:month/', 'articles');

// Products
$router->request('/parts/:catSlug/:productSlug', 'product');
$router->request('/parts/:catSlug/:productSlug/', 'product');

// shop

$router->filter('filter/signed-in-subscribed', function () use ($router) {
	$router->post('/basket/add', 'shop/basket/add');
});

$router->filter('filter/signed-in', function () use ($router) {

	$router->get('/basket', 'shop/basket/show');
	$router->get('/basket/', 'shop/basket/show');
	$router->post('/basket/add-ragalia', 'shop/basket/add-ragalia');
	$router->post('/basket/discard', 'shop/basket/discard');
	$router->post('/basket/update', 'shop/basket/update');
	$router->post('/basket/update-shipping', 'shop/basket/update-shipping');
	$router->post('/basket/update-shipping-type', 'shop/basket/update-shipping-type');
	$router->post('/basket/update-shipping-zone', 'shop/basket/update-shipping-zone');

	$router->filter('shop/filter/basket-has-items', function () use ($router) {

		$router->request('/checkout', 'shop/checkout');
		$router->request('/checkout/', 'shop/checkout');

		$router->filter('shop/filter/checkout-has-address', function () use ($router) {
			$router->request('/checkout/confirm', 'shop/checkout-confirm');
			$router->request('/checkout/confirm/', 'shop/checkout-confirm');
			$router->request('/checkout/complete', 'shop/checkout-complete');
			$router->request('/checkout/complete/', 'shop/checkout-complete');
			$router->post('/checkout/discount', 'shop/checkout-discount');
			$router->post('/checkout/discount/', 'shop/checkout-discount');
		});

	});

});

// Search
$router->request('/search', 'search');
$router->request('/search/', 'search');

$router->get('/discard', 'shop/basket/discard');

// AJAX
$router->request('/ajax/create-chain', 'ajax/create-chain');
$router->request('/ajax/chain', 'ajax/chain');
$router->request('/ajax/add-chain', 'ajax/add-chain');
$router->request('/ajax/postcode', 'ajax/postcode');
$router->request('/ajax/property', 'ajax/property');

// not found page

$app->notFound('404');

// messages box
// $app->seeOther('#messages');

// static pages -- this must be the last route defined

$router->get('/:name', 'page')->where('name', '.+?');
