<?php
/**
 * The template for displaying all single quiz and attachments
 */

get_header(); ?>

<div id="ti-primary" class="ti-content-area">
	<main id="ti-main" class="ti-site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
    ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="ti-entry-header">
          <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header><!-- .entry-header -->

        <div class="ti-entry-content">
          <?php
            echo '<div class="mleft">';
            the_content();
            echo '</div>';
            echo '<div class="ti-clearfix"></div>';
            if(function_exists('get_field') ){
              $questions = get_field('questions', $post->ID);
            }
          ?>
        
        <div class="wrapper">
            <div class="questions-wrap">
                <form name="ti-quiz" method="POST" id="ti-quizForm" class="ti-quizForm">
                <?php if (!empty($questions)) { 
                        $i = 0;
                        foreach($questions as $q) {
                          $layout = $q['layout'];
                          $layout_class = '';
                          if($layout === 'Grid') {
                           $layout_class =  'col-md-4';
                          }
                          else {
                            $layout_class = 'list';
                          }
                  ?>
                  <div class="quiz-wrapper question<?php echo $i; ?>">
                      <div class="quiz-title">
                          <p><?php echo $q['question']; ?></p>
                      </div>
                      <?php if (!empty($q['answers'])) {
                              $j = 0;
                              foreach($q['answers'] as $a) {
                                $answer = $a['answer'];
                      ?>
                                <div class="quiz-answer <?php echo $layout_class ?>">
                                    <label class="answer<?php echo $j; ?>"><input type="radio" name="q<?php echo $i; ?>" class="answer" value=<?php echo "'$answer'"; ?>><?php echo $answer; ?></label>
                                </div>
                      <?php
                                $j++;
                              }
                      } ?>
                  </div>
                  <?php 
                          $i++;
                        } 
                          } ?>
                  </form>
            </div>
        </div><!-- wrapper -->
        </div><!-- .entry-content -->
        

        <footer class="ti-entry-footer">
        </footer>
      </article><!-- #post-## -->

    <?php  
			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer();

