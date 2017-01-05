<?

Class Seo extends CI_Controller {

    function sitemap()
    {

    	$artists = $this->artists_model->get_artists();
        $releases = $this->releases_model->get_releases();
        $products = $this->merch_model->get_merch();
        $articles = $this->blog_model->get_articles();
        $videos = $this->videos_model->get_videos();

        $data = "";//select urls from DB to Array
        $data['urls'] = array(
        	'about',
        	'artists',
        	'releases',
        	'merch',
        	'blog',
        	'videos',
        	'contact',
        );

        foreach($articles as $article) {
        	array_push($data['urls'], 'blog/' . $article['content_link']);
        } // endforeach

        foreach($artists as $artist) {
        	array_push($data['urls'], 'artists/' . $artist['artist_link']);
        } // endforeach

        foreach($releases as $release) {
        	array_push($data['urls'], 'releases/' . $release['music_link']);
        } // endforeach

        foreach($products as $product) {
        	array_push($data['urls'], 'merch/' . $product['merch_link']);
        } // endforeach

        foreach($videos as $video) {
        	array_push($data['urls'], 'videos/' . $video['slug']);
        } // endforeach

        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap", $data);
    }
}

?>