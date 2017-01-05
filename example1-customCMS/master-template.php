<?

if(isset($menu) == false) {
	$menu = empty($sitemap['/']) ? array() : $sitemap['/'];
}
$dir=$_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en-GB">

<head>

	<meta charset="UTF-8" />
<?  if($dir == "/"){?>
		<meta name="robots" content="index, follow">
<?  }else {?>
		<meta name="robots" content="noindex, nofollow">
<?  } ?>



	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?	if(empty($entity->meta_title) == false) { ?>
	<title><?= $this->e($entity->meta_title); ?></title>
<?	} elseif(empty($entity->title) == false) { ?>
	<title><?= $this->e($entity->title) . ' - ' . _t('title:website'); ?></title>
<?	} elseif(empty($entity->name) == false) { ?>
	<title><?= $this->e($entity->name) . ' - ' . _t('title:website'); ?></title>
<?	} else { ?>
	<title><?= _t('title:website'); ?></title>
<?	} // endif ?>

	<meta name="title" content="SeeYourChain | Home">
	<meta name="description" content="<?= $this->e($entity->meta_description); ?>">

<?	if(empty($canonical) == false) { ?>
	<link rel="canonical" href="<?= $this->e($canonical); ?>" />
<?	} // endif ?>

		<!-- Twitter Title -->
<?	if(!empty($seoRecord)) { ?>
	<meta name="twitter:title" content="<?= $seoRecord->twitter_title; ?>">
<?	} else if(empty($entity->meta_title) == false) { ?>
	<meta name="twitter:title" content="<?= $this->e($entity->meta_title); ?>">
<?	} elseif(empty($entity->title) == false) { ?>
	<meta name="twitter:title" content="<?= $this->e($entity->title) . ' - ' . _t('title:website'); ?>">
<?	} elseif(empty($entity->name) == false) { ?>
	<meta name="twitter:title" content="<?= $this->e($entity->name) . ' - ' . _t('title:website'); ?>">
<?	} else { ?>
	<meta name="twitter:title" content="<?= _t('title:website'); ?>">
<?	} // endif ?>

	<!-- Twitter Description -->
<?	if(!empty($seoRecord)) { ?>
		<meta property="twitter:description" content="<?= $this->e($seoRecord->twitter_description); ?>" />
<?	} else { ?>
<?		if(empty($entity->meta_description) == false) { ?>
			<meta property="twitter:description" content="<?= $this->e($entity->meta_description); ?>" />
<?		} // endif ?>
<?	} // endif ?>

	<!-- Twitter Image -->
<?	if(empty($entity->meta_title) == false) { ?>
<?		if($entity->image) { ?>
<?			if(!empty($seoRecord)) { ?>
				<meta property="twitter:image" content="<?= $shortURL . $seoRecord->twitter_image; ?>">
<?			} else { ?>
				<meta property="twitter:image" content="/img/logo-new.png" />
<?			} // endif ?>
<?		} else { ?>
			<meta property="twitter:image" content="/img/logo-new.png" />
<?		} // endif ?>
<?	} // endif ?>

	<!-- Twitter Card -->
	<meta name="twitter:card" content="<?= $this->e($entity->meta_description); ?>" />

		<!-- Facebook Title -->
<?	if(!empty($seoRecord)) { ?>
	<meta name="og:title" content="<?= $seoRecord->facebook_title; ?>">
<?	} else if(empty($entity->meta_title) == false) { ?>
	<meta name="og:title" content="<?= $this->e($entity->meta_title); ?>">
<?	} elseif(empty($entity->title) == false) { ?>
	<meta name="og:title" content="<?= $this->e($entity->title) . ' - ' . _t('title:website'); ?>">
<?	} elseif(empty($entity->name) == false) { ?>
	<meta name="og:title" content="<?= $this->e($entity->name) . ' - ' . _t('title:website'); ?>">
<?	} else { ?>
	<meta name="og:title" content="<?= _t('title:website'); ?>">
<?	} // endif ?>
	<meta name="og:type" content="http://seeyourchain.com">

	<!-- Facebook Description -->
<?	if(!empty($seoRecord)) { ?>
		<meta property="og:description" content="<?= $this->e($seoRecord->facebook_description); ?>" />
<?	} else { ?>
<?		if(empty($entity->meta_description) == false) { ?>
			<meta property="og:description" content="<?= $this->e($entity->meta_description); ?>" />
<?		} // endif ?>
<?	} // endif ?>

	<!-- Facebook Image -->
<?	if(empty($entity->image) == false) { ?>
<?		if($entity->image) { ?>
<?			if(!empty($seoRecord)) { ?>
				<meta property="og:image" content="<?= $shortURL . $seoRecord->facebook_image; ?>">
<?			} else { ?>
				<meta property="og:image" content="http://www.ed-mead.com/logo.png" />
<?			} // endif ?>
<?		} else { ?>
			<meta property="og:image" content="http://www.ed-mead.com/logo.png" />
<?		} // endif ?>
<?	} // endif ?>

	<!-- Facebook URL -->
	<meta property="og:url" content="http://seeyourchain.com" />

	<script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "Seeyourchain",
	    "telephone": "0117 3252020",
        "logo": "http://www.seeyourchain.com/img/logo-new.png",
        "url": "http://www.seeyourchain.com",
        "address": {
	    "@type": "PostalAddress",
	    "addressLocality": "Taunton",
	    "addressRegion": "Somerset",
	    "postalCode":"TA1 1DG",
	    "streetAddress": "55 Staplegrove Road"
	        },
	    "description": "Seeyourchain - The affordable way for estate agents, sellers and buyers to see exactly and visually what's going on in their chain.",
	    "sameAs" : [ 	"https://www.facebook.com/seeyourchain/",
						"https://twitter.com/seeyourchain",
						"https://www.linkedin.com/company/seeyourchain"
				]
	    }
	</script>


	<style>

		DIV.n-header {
		    font-family: "Raleway", sans-serif !important;
		    background-image: url("../img/header_new.png");
		    background-size: cover;
		    background-position: center;
		    padding: 150px 0 300px
		}

		DIV.n-header IMG {
		    max-width: 80%
		}

		DIV.n-header H1 {
		    color: #fff !important;
		    font-weight: 400 !important;
		    max-width: 800px;
		    margin: auto;
		    margin-top: 60px
		}

		DIV.n-header H1 SPAN {
		    color: #87a92e;
		    text-transform: uppercase;
		    font-weight: 600
		}

	</style>

</head>

<?
if($dir == "/"){?>
<body class="holding" id="top"> <?
}else {
   echo "<body>";
} ?>



<header>
	<div class="n-header">
		<div class="text-center">
			<img src="/img/logo_col.png" alt="See Your Chain">
			<h1>Combining <span>traditional</span> estate agency with <span>modern</span> technology</h1>
			<a href="#n-contact" class="button-green">contact us</a>
		</div>
	</div>
<?/** 	<div class="container-fluid">
		<div class="row">
			<div class="header">
				<a class="logo" href="/">
					<img class="responsive logoMain" alt="Seeyourchain logo" src="/img/logo-small.png" />
					<img class="responsive logoMobile" alt="Seeyourchain logo" src="/img/logo-mobile-new.png" width="110px" />
				</a>
				<div class="nav">
					<ul class="nav" id="menu">
<?                      foreach($menu as $_url => $_entity) {
                            if($_entity->name == 'Sign In / Register') {
                                if($user) { ?>
                                    <li><a href="/dashboard">Dashboard</a></li>
                                    <li><a href="/auth/login">Logout</a></li>
<?                              } else { ?>
                                    <li><a href="<?= $this->e($_url); ?>"><?= $this->e($_entity->name); ?></a></li>
<?                              } // endif ?>
<?                          } else { ?>
                                <li><a href="<?= $this->e($_url); ?>"><?= $this->e($_entity->name); ?></a></li>
<?                          } // endif
                        } // endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		<?	$this->stub('slideshow'); ?>
	</div> **/?>
</header>

<link rel="stylesheet" href="/stylesheets/screen2.css?ver=10" />
<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/css/font-awesome.min.css" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

<?	if(empty($entity->breadcrumb) == false) { ?>
<?		if(key($entity->breadcrumb) === '/') { ?>
<?			array_shift($entity->breadcrumb); ?>
<?		} // endif ?>


		<div class="breadcrumb">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumbs">
							<li>
								<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a class="home" itemprop="url" href="/">
										<span itemprop="name"><?= $this->e($staticPages['/']->name); ?></span>
										<meta itemprop="position" content="1" />
									</a>
								</span>
							</li>
<?							// TODO sort 'position' property ?>
<?							foreach($entity->breadcrumb as $_url => $_entity) { ?>
								<li>
									<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
<?										if(empty($_url) || $_url == $app->requestPath()) { ?>
											<span itemprop="name"><?= $this->e(is_string($_entity) ? $_entity : $_entity->name); ?></span>
											<meta itemprop="position" content="2" />
<?										} else { ?>
												<a class="home" itemprop="url" href="<?= $this->e($_url); ?>">
												<span itemprop="name"><?= $this->e(is_string($_entity) ? $_entity : $_entity->name); ?></span>
												<meta itemprop="position" content="1" />
											</a>
<?										} // endif ?>
									</span>
								</li>
<?							} // endforeach ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
<?	} // endif ?>


<?	if( ($dir != '/') ) { ?>
<?	$this->start('messages'); ?>

<?= $this->template('partial/messages'); ?>

<?	$this->stop(); ?>
<?	} // endif ?>


<? 	$this->stub('slideshow'); ?>

<?	$this->stub('productsRow'); ?>

<?	$this->stub('slideshow2'); ?>

<?	$this->stub('content:before'); ?>
<?	$this->start('content'); ?>
<?	if(empty($entity->content) == false) { ?>

	<?= $entity->content; ?>

<?	} // endif ?>
<?	$this->stop(); ?>
<?	$this->stub('content:after'); ?>

<?	$this->stub('contentMain'); ?>

<?	$this->stub('carousel'); ?>

<?	$this->start('footer'); ?>
<footer class="main-footer">
	<div class="container-fluid">
		<div class="row">
			<div class="copyright-container col-md-9">
				Copyright &copy; <?= date('Y'); ?>. All rights reserved | <a href="/terms">Terms & Conditions</a> | <a href="/privacy-policy">Privacy Policy</a> | <a href="/support">Support</a> | Contact Us on <a href="tel:+44 (0) 117 325 2020">+44 (0) 117 325 2020</a>
			</div>
			<div class="social-container col-md-3">
				<ul>
					<li>
						<a href="https://www.facebook.com/seeyourchain/">
							<i class="fa fa-facebook"></i>
						</a>
					</li>
					<li>
						<a href="https://twitter.com/seeyourchain">
							<i class="fa fa-twitter"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-linkedin"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<?	$this->stop(); ?>
<?= $this->template('partial/scripts'); ?>

