<?php
ob_start();
?>
<section class="menu section bd-container" id="menu">
    <span class="section-subtitle">Special</span>
    <h2 class="section-title">Menu of the Week</h2>

    <!-- Search Form -->
    <div class="search__container bd-container">
        <form method="GET" action="index.php" class="search__form">
            <input type="hidden" name="action" value="menu">
            <input type="text" name="recherche" placeholder="Search dishes..." class="search__input" 
                   value="<?php echo isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : ''; ?>">
            <button type="submit" class="button">Search</button>
        </form>
    </div>

    <div class="menu__container bd-grid">
        <?php 
        $plats = isset($_GET['recherche']) ? rechercherPlats($_GET['recherche']) : obtenirTousLesPlats();

        if (!empty($plats)):
            foreach ($plats as $plat): 
        ?>
            <div class="menu__card">
                <div class="menu__card-img">
                    <?php if (!empty($plat['url_image'])): ?>
                        <img src="<?php echo htmlspecialchars($plat['url_image']); ?>" alt="<?php echo htmlspecialchars($plat['nom']); ?>">
                    <?php else: ?>
                        <img src="assets/img/default-dish.jpg" alt="Default dish image">
                    <?php endif; ?>
                    <span class="menu__card-category"><?php echo htmlspecialchars($plat['categorie']); ?></span>
                </div>
                <div class="menu__card-content">
                    <h3 class="menu__card-title"><?php echo htmlspecialchars($plat['nom']); ?></h3>
                    <p class="menu__card-description"><?php echo htmlspecialchars($plat['description']); ?></p>
                    <div class="menu__card-footer">
                        <span class="menu__card-price">$<?php echo htmlspecialchars($plat['prix']); ?></span>
                        <button class="button menu__card-button">
                            <i class='bx bx-cart-alt'></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php 
            endforeach;
        else:
        ?>
            <div class="menu__empty">
                <i class='bx bx-search-alt menu__empty-icon'></i>
                <p>No dishes found</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
$page = ob_get_clean();
?> 