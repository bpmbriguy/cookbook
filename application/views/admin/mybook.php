<div id="tabs_container">
    <ul id="tabs">
        <li class="active"><a href="#recipes">My Recipes</a></li>
        <li><a href="#bookmarks">Bookmarked Recipes</a></li>
    </ul>
</div>
<div id="tabs_content_container">
    <div id="recipes" class="tab_content">
        <?php if(!count($recipes)) echo "<h2>You have not added a recipe yet</h2>"; ?>
    </div>
    <div id="bookmarks" class="tab_content">
        <?php if(!count($bookmarks)) echo "<h2>You have not bookmarked a recipe yet</h2>"; ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        
        $("#recipes").show();
        
        //  When user clicks on tab, this code will be executed
        $("#tabs li").click(function() {
            //  First remove class "active" from currently active tab
            $("#tabs li").removeClass('active');

            //  Now add class "active" to the selected/clicked tab
            $(this).addClass("active");

            //  Hide all tab content
            $(".tab_content").hide();

            //  Here we get the href value of the selected tab
            var selected_tab = $(this).find("a").attr("href");

            //  Show the selected tab content
            $(selected_tab).fadeIn();

            //  At the end, we add return false so that the click on the link is not executed
            return false;
        });
        
   
        var recipes = <?php echo json_encode($recipes); ?>;
        var recipe_tree = build_recipe_tree(recipes);
        recipe_tree.appendTo('#recipes');
        
        function build_recipe_tree(recipes) {
            
            var tree = $('<ul>');
            
            for (var x in recipes) {
                
                if (typeof recipes[x] === "object") {
                    var span = $('<span>').html(x).appendTo(
                        $('<li>').appendTo(tree).addClass('folder')
                        );
                        var subtree = build_recipe_tree(recipes[x]).hide();
                        span.after(subtree);
                        span.click(function() {
                        $(this).parent().find('ul:first').toggle();
                        });
                } else {
                    if(recipes.hasOwnProperty(x)){
                        $('<li>').html('<a href="<?php echo base_url();?>recipe/view/' + x + '">' + recipes[x] + '</a>').appendTo(tree).addClass('recipe');
                    }
                }
                
            }

            return tree;
        }

        var bookmarks = <?php echo json_encode($bookmarks); ?>;
        var bookmark_tree = build_bookmark_tree(bookmarks);
        bookmark_tree.appendTo('#bookmarks');
        
        function build_bookmark_tree(bookmarks) {
            
            var tree = $('<ul>');
            
            for (var x in bookmarks) {
                
                if (typeof bookmarks[x] === "object") {
                    var span = $('<span>').html(x).appendTo(
                        $('<li>').appendTo(tree).addClass('folder')
                        );
                        var subtree = build_bookmark_tree(bookmarks[x]).hide();
                        span.after(subtree);
                        span.click(function() {
                        $(this).parent().find('ul:first').toggle();
                        });
                } else {
                    if(bookmarks.hasOwnProperty(x)){
                        $('<li>').html('<a href="<?php echo base_url();?>recipe/view/' + x + '">' + bookmarks[x] + '</a>').appendTo(tree).addClass('bookmark');
                    }
                }
                
            }

            return tree;
        }
    });
</script>