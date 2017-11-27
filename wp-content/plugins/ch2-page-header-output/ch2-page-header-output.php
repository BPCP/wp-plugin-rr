<?php

/*
  Plugin Name: Chapter 2 – Page Header Output .
  Plugin URI:
  Description:
  Version: 1.0.0
  Author: brian
  Author URI:
  License: GPLv2
 */

/*
  Copyright (C) 2017 brian

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
add_action('wp_head', 'ch2pho_page_header_output');

function ch2pho_page_header_output() {
    ?>
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' \n\ type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
        try {
            var pageTracker = _gat._getTracker("UA-xxxxxx-x");
            pageTracker._trackPageview();
        } catch (err) {
        }
    </script>
    <?php

}
