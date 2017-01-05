<?

$location = '/dashboard/buyers';

// Get the static page with the location
if(isset($staticPages[$location])) {
	$entity = $staticPages[$location];
} // endif

// If no static page found
if(empty($entity)) {
	return $app->notFound();
} // endif

if(empty($user)) {

	$app->redirect('/auth/login');

} else {

	// Get the buyers
	$allBuyers = $users->find()->where('user_type', 3)->where('owned_by', $user->id)->orderBy('first_name', 'asc');

	// If searching a buyers name / email
	if(isset($searchQuery)) {
		if($searchQuery != 'none') {
			$allBuyers = $allBuyers->search($searchQuery);
		} else {
			$searchQuery = null;
		} // endif
	} else {
		$searchQuery = null;
	} // endif

} // endif

// When the form is submitted
if($request->method() == 'POST') {

	$values = $request->toArray();

	// If there is no search criteria, go to the top page
	if(!$values['searchQuery']) {
		$app->seeOther('/dashboard/buyers');
	} else {
		$app->seeOther('/dashboard/buyers/search/' . $values['searchQuery']);
	} // endif

} // endif

$entity->breadcrumb = breadcrumb($pages, $entity);

// Pass the variables to the template
return $template('dashboard/buyers', array(
	'entity' => $entity,
	'allBuyers' => $allBuyers,
	'searchQuery' => $searchQuery,
));
