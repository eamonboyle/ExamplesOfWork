<?

$location = '/dashboard/buyers';

if(isset($staticPages[$location])) {
	$entity = $staticPages[$location];
}

if(empty($entity)) {
	return $app->notFound();
}

if(empty($user)) {

	$app->redirect('/auth/login');

} else {

	// Get the chain
	$allBuyers = $users->find()->where('user_type', 3)->where('owned_by', $user->id)->orderBy('first_name', 'asc');

	// If searching an estate agent
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

return $template('dashboard/buyers', array(
	'entity' => $entity,
	'allBuyers' => $allBuyers,
	'searchQuery' => $searchQuery,
));
