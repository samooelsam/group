<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div class="footer-image">
 <div class="footer-image-container">
  <img src="/wp-content/uploads/2017/10/JFH-Illustration-Banner-6-New-Lighter-Blue-Screen-e1540541150705.png" />
 </div>
</div>
<div class="footer">
 <div class="footer-container">
  <div class="footer-container-Contact">
    <h>Our Services</h>
	<p><a href="/demolition/">Demolition</a></p>
	<p><a href="https://www.johnfhuntregeneration.co.uk">Regeneration</a></p>
	<p><a href="/concrete-cutting/">Concrete Cutting</a></p>
	<p><a href="/environmental/">Asbestos Abatement</a></p>
	<p><a href="https://www.johnfhuntpower.co.uk/">Power Generator Hire</a></p>
	<p><a href="/hire-centres/">Hire Centres</a></p>
	<p><a href="/plant-hire/">Plant Hire & Sales</a></p>
   </div>
 <div class="footer-container-Contact">
	<p><a href="/industrial/">Industrial</a></p>
	<p><a href="/thameside-lifting/">Lifting Equipment Hire & Testing</a></p>
	<p><a href="https://www.aceconsultants.co.uk/" target="_blank">ACE</a></p>
	<p><a href="http://www.bdnuclear.co.uk/" target="_blank">BD Nuclear</a></p>
    <p><a href="http://www.thamesidesupplies.co.uk/" target="_blank">Thameside Supplies</a></p>
	<p><a href="https://www.mardykevalley.co.uk/" target="_blank">Mardyke Valley</a></p>
    <p><a href="https://www.techvertu.co.uk" target="_blank">TechVertu</a></p>
    </div>
  <div class="footer-container-Contact">
    <h>Contact Details</h>
     <p>John F Hunt Group, London Road, Grays, Essex, RM20 4DB<br />
       Tel: +44 (0)1375 366 700<br />
       Email: <a href="mailto:info@johnfhunt.co.uk">John F Hunt Info</a></p>
	   <h>Emergency out of hours<br />
	  Contact <a href="tel://01375 366700">01375 366810</a></h>
	 </div>
	<div class="footer-container-Contact">
<!-- TISCreport AFFILIATE CODE f5652f2bf0ac43669e7624cbe6686e90 --><a href="https://tiscreport.org" title="UK modern slavery act compliance and  anti-slavery statement central registry"><img alt="UK modern slavery act compliance and  anti-slavery statement central registry" src="https://tiscreport.org/affiliate/affiliate-light.png?aff_code=f5652f2bf0ac43669e7624cbe6686e90"/></a><!--END OF CODE-->
  </div>
 </div>



 <div class="copyright">
	 <p>© Copyright 2016 - John F Hunt Group. All Rights Reserved. | <a href="/privacy-policy/" target="_blank">Privacy Policy |</a>
 <a href="/terms-of-website-use/" target="_blank">Terms & Conditions</a><br />
		 Web & <a href="https://www.techvertu.co.uk/">IT Support</a> - <a href="https://www.johnfhunt.co.uk/it-support-by-techvertu/">TechVertu</a>
 </p>
 </div>
 </div>
</div>
<?php get_sidebar( 'footer' ); ?>

			<div class="site-info">
				<?php do_action( 'twentyfourteen_credits' ); ?>
				<a href="<?php echo esc_url( __( 'https://www.johnfhunt.co.uk/', 'twentyfourteen' ) ); ?>"><?php printf( __( ' %s', 'johnfhunt' ), '' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>