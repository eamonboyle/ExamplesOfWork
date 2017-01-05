<?

Class Seo extends CI_Controller {

    function sitemap()
    {

        // Get all of the sites content
    	$artists = $this->artists_model->get_artists();
        $releases = $this->releases_model->get_releases();
        $products = $this->merch_model->get_merch();
        $articles = $this->blog_model->get_articles();
        $videos = $this->videos_model->get_videos();

        // Initiate the urls array
        $data['urls'] = array(
        	'about',
        	'artists',
        	'releases',
        	'merch',
        	'blog',
        	'videos',
        	'contact',
        );

        // Push the blog articles into the array
        foreach($articles as $article) {
        	array_push($data['urls'], 'blog/' . $article['content_link']);
        } // endforeach

        // Push the artists into the array
        foreach($artists as $artist) {
        	array_push($data['urls'], 'artists/' . $artist['artist_link']);
        } // endforeach

        // Push the releases into the array
        foreach($releases as $release) {
        	array_push($data['urls'], 'releases/' . $release['music_link']);
        } // endforeach

        // Push the products into the array
        foreach($products as $product) {
        	array_push($data['urls'], 'merch/' . $product['merch_link']);
        } // endforeach

        // Push the videos into the array
        foreach($videos as $video) {
        	array_push($data['urls'], 'videos/' . $video['slug']);
        } // endforeach

        // Change the header to XML
        header("Content-Type: text/xml;charset=iso-8859-1");

        // Load the view
        $this->load->view("sitemap", $data);
    }
}

?>