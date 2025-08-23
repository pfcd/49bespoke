<?php 

$logo = DNWOO_ESSENTIAL_ASSETS . "images/admin/logo.png";
?>

<div class="dnwooe-admin wrapper">
	<div class="dnwooe-admin-header">
		<div class="dnwooe-admin-logo-inline">
			<img class="dnwooe-logo-icon-size" src="<?php echo esc_attr($logo); ?>" alt="">
        </div>
        <div class="dnwooe-nav" role="tablist">
			<nav class="dnwooe-tabs-nav">
                <?php 
                    $tab_count = 1;

                    foreach( self::get_tabs() as $slug => $item ) :

                        $slug = esc_attr( strtolower( $slug ) );

                        $class = ' dnwooe-admin-nav-item-link';

                        if ( $tab_count === 1 ) {
                            $class .= ' active-tab';
                        }

                        if ( ! empty( $item['href'] ) ) {
                            $href = esc_url( $item['href'] );
                        } else {
                            $href = '#' . $slug;
                        }

                        printf(
                            '<a href="%1$s" aria-controls="tab-content-%2$s" id="tab-nav-%2$s" class="%3$s" role="tab">
                                %5$s
                            </a>
                            <style type="text/css"> #tab-nav-%2$s { background-image: url(%4$s); } </style>
                            ',
                            esc_url( $href ),
                            esc_attr( $slug ),
                            esc_attr( $class ),
                            esc_url( $item['icon'] ),
                            esc_html( $item['title'] )
    
                        );
                        ++$tab_count;

                    endforeach;
                ?>
            </nav>
        </div>
    </div>
    <div class="dnwooe-admin-tabs">
        <div class="dnwooe-admin-tabs-content">
        <?php
				$tab_count = 1;

			    foreach ( self::get_tabs() as $slug => $item ) :
                    $class = 'dnwooe-admin-tabs-content-item';
                    if ( $tab_count === 1 ) {
                        $class .= ' active-tab';
                    }
                    $slug = esc_attr( strtolower( $slug ) );

                    ?>

                        <div class="<?php echo esc_attr( $class ); ?>" id="tab-content-<?php echo esc_attr( $slug ); ?>" role="tabpanel" aria-labelledby="tab-nav-<?php echo esc_attr( $slug ); ?>">
                        <?php call_user_func( $item['renderer'], $slug, $item ); ?>
                        </div>

                    <?php

                ++$tab_count;
				endforeach;
			?>
        </div>
    </div>
</div>