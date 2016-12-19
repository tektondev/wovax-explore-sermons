<nav class="wovax-es-nav">
	<ul>
    	<li class="es-active <?php $this->check_active( $active_section , 'all' );?>">
        	<label for="browse-by-all">All&nbsp;Sermons</label><input id="browse-by-all" type="radio" name="browse_by" value="all" <?php checked( $active_section , 'all' , true );?> />
        </li><li class="<?php $this->check_active( $active_section , 'scriptures' );?>">
        	<label for="browse-by-scriptures">Scriptures</label><input id="browse-by-scriptures" type="radio" name="browse_by" value="scriptures" <?php checked( $active_section , 'scripture' , true );?> />
        </li><li class="<?php $this->check_active( $active_section , 'topics' );?>">
        	<label for="browse-by-topics">Topics</label><input id="browse-by-topics" type="radio" name="browse_by" value="topics" <?php checked( $active_section , 'topics' , true );?> />
        </li><li class="<?php $this->check_active( $active_section , 'series' );?>">
        	<label for="browse-by-series">Series</label><input id="browse-by-series" type="radio" name="browse_by" value="series" <?php checked( $active_section , 'series' , true );?> />
        </li><li class="<?php $this->check_active( $active_section , 'pastors' );?>">
        	<label for="browse-by-pastors">Pastors</label><input id="browse-by-pastors" type="radio" name="browse_by" value="pastors" <?php checked( $active_section , 'pastors' , true );?> />
        </li>
	</ul>
</nav>