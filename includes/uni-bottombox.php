		
		<?php if ( is_active_sidebar( 'tmnf-footer-1' ) ) { ?>
    
            <div class="foocol first"> 
            
                <?php dynamic_sidebar('tmnf-footer-1')?>
                
            </div>
        
        <?php } ?>
		
		<?php if ( is_active_sidebar( 'tmnf-footer-2' ) ) { ?>
    
            <div class="foocol"> 
            
                <?php dynamic_sidebar('tmnf-footer-2')?>
                
            </div>
        
        <?php } ?>
        
        
        <?php if ( is_active_sidebar( 'tmnf-footer-3' ) ) { ?>
        
            <div class="foocol">
            
                <?php dynamic_sidebar('tmnf-footer-3') ?>
                
            </div>
        
        <?php } ?>
        
        
        <?php if ( is_active_sidebar( 'tmnf-footer-4' ) ) { ?>
        
            <div class="foocol last"> 
            
                <?php dynamic_sidebar('tmnf-footer-4') ?>
                
            </div>
        
        <?php } ?>