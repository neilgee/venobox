

<h2><?php _e( 'Venobox Lighbox Plugin', 'wp_admin_style' ); ?></h2>

<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_attr_e( 'Venobox', 'wp_admin_style' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h3><span><?php esc_attr_e( 'Markup instructions on how to use the Venobox Lightbox', 'wp_admin_style' ); ?></span></h3>

						<div class="inside">
              <p>Below are instructions for using the Venobox Lightbox for your code, typically for the lightbox to work  you wrap a link around a text or image element.
              <pre>&lt;a class="venobox" data-type="vimeo" href="https://vimeo.com/1084537"&gt;&lt;img src="..." /&gt;&lt;/a&gt;
              </pre>
              <a class="venobox" data-type="vimeo" href="https://vimeo.com/1084537">
              <?php
                echo '<img src="' . plugins_url( 'images/bunny.jpg', dirname(__FILE__) ) . '" > ';
                ?>
              </a>
              <p>When clicked the lightbox will execute showing the linked content.</p>

              <p>To use <strong>Venobox</strong> you need to ensure the CSS class <code>class="venobox"</code> is used in the link mark up and also if the lightbox content is not an image the <code>data-type</code> attribute is also required <code>data-type="vimeo"</code>(or other).</p>
                <h4>Data Types</h4>
              <p>If the content is not an image you have to specify its type via data attribute <code>data-type</code></p>
              <p>Available data-type values: <code>youtube</code> <code>vimeo</code> <code>iframe</code> <code>inline</code> <code>ajax</code> </p>

      <pre data-initialized="true" data-gclp-id="4">
      &lt;a class="venobox" data-type="iframe" href="http://www.veno.es"&gt;Open Iframe&lt;/a&gt;
      &lt;a class="venobox" data-type="inline" title="My Description" href="#inline"&gt;Open inline content&lt;/a&gt;
      &lt;a class="venobox" data-type="ajax" href="ajax-call.php"&gt;Retrieve data via Ajax&lt;/a&gt;
      &lt;a class="venobox" data-type="youtube" href="http://youtu.be/d85gkOXeXG4"&gt;YouYbe&lt;/a&gt;
      &lt;a class="venobox" data-type="vimeo" href="http://vimeo.com/75976293"&gt;Vimeo&lt;/a&gt;
      </pre>
        <h4>Title</h4>
              <p>Optional: set <code>title</code> attribute to show a description</p>
      <pre data-initialized="true" data-gclp-id="5">
      &lt;a class="venobox" title="Here is your description" href="...
      </pre>
        <h4>Auto Play</h4>

              <p>Use <code>data-autoplay="true"</code> to automatically start Vimeo and YouTube videos once the text or image link is clicked</p>

      <pre data-initialized="true" data-gclp-id="6">
      &lt;a class="venobox" data-autoplay="true" data-type="vimeo" href="...
      &lt;a class="venobox" data-autoplay="true" data-type="youtube" href="...
      </pre>
        <h4>Overlay colors</h4>
        <p><strong>Examples:</strong><br>
            <a class="venobox btn btn-default vbox-item" data-type="inline" data-gall="colors" data-overlay="rgba(95,164,255,0.8)" href="#inline-1" style="background:rgba(95,164,255,0.8); color:#fff;">Color 1</a>
            <a class="venobox btn btn-default vbox-item" data-type="inline" data-gall="colors" data-overlay="rgba(51,0,255,0.8)" href="#inline-2" style="background:rgba(51,0,255,0.8); color:#fff;">Color 2</a>
            <a class="venobox btn btn-default vbox-item" data-type="inline" data-gall="colors" data-overlay="rgba(202,45,164, 0.8)" href="#inline-3" style="background:rgba(202,45,164, 0.8); color:#fff;">Color 3</a>
            <a class="venobox btn btn-default vbox-item" data-type="inline" data-gall="colors" data-overlay="#ffe74c" href="#inline-4" style="background:#ffe74c; color:#fff;">Color 4</a>
        </p>
        <p>
        Just add a <code>data-overlay</code>attribute value to your links for dynamic backgrounds</p>
      <pre data-initialized="true" data-gclp-id="9">
      &lt;a class="venobox" data-overlay="rgba(95,164,255,0.8)" href="..."&gt;...&lt;/a&gt;
      &lt;a class="venobox" data-overlay="#ca294b" href="..."&gt;...&lt;/a&gt;
      </pre>
    </p>

        <div id="inline-1" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>Custom</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>
        <div id="inline-2" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>Background</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>
        <div id="inline-3" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>Colors</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>
        <div id="inline-4" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>RGBA or FULL</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>


        <div id="inline-1" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>Custom</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>
        <div id="inline-2" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>Background</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>
        <div id="inline-3" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>Colors</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>
        <div id="inline-4" style="display:none;">
            <div style="background:#fff; width:100%; height:100%; float:left; padding:10px;">
            <h1>RGBA or FULL</h1>
            <p>set different custom overlay colors for each link</p>
            </div>
        </div>


						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2><span><?php esc_attr_e(
									'Further Reference', 'wp_admin_style'
								); ?></span></h2>

						<div class="inside">
							<p>
									Venobox is the work of @NicolaFranchini<br>
                  More here at <a href="http://lab.veno.it/venobox/" target="_blank">Plugin Home</a> and <a href="https://github.com/nicolafranchini/VenoBox/" target="_blank">Github</a>,
							</p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->
