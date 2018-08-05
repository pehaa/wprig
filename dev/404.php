<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title">Cette page n'existe pas</h1>
				<img class="img-404" src="<?php echo get_template_directory_uri() . '/images/templates/logo-404.svg'; ?>" alt="404">
			</header><!-- .page-header -->

			<div class="page-content">
				<p>Oups. Il semblerait que ce que vous cherchez a été déplacé ou n’existe simplement pas&hellip;</p>
				<p>Désolés pour la gène occasionnée. :(</p>
				<a href="">Retour à l'accueil</a>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #primary -->

<?php
get_footer();
