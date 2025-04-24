<?php
ob_start();
?>
<section class="admin section bd-container" id="admin">
    <div class="admin__container bd-grid">
        <div class="admin__data">
            <span class="section-subtitle admin__initial">Admin Panel</span>
            <h2 class="section-title admin__initial">Manage Menu Items</h2>
            
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message__success">
                    <?php 
                    echo htmlspecialchars($_SESSION['message']); 
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>

            

            <!-- Add/Edit Form -->
            <div class="form__container">
                <h3><?php echo isset($_GET['id']) ? 'Edit Menu Item' : 'Add New Menu Item'; ?></h3>
                <form method="POST" action="index.php?action=admin<?php echo isset($_GET['id']) ? '&id=' . htmlspecialchars($_GET['id']) : ''; ?>" enctype="multipart/form-data">
                    <div class="form__group">
                        <input type="text" 
                               name="nom" 
                               required 
                               placeholder="Item Name" 
                               class="form__input"
                               value="<?php echo isset($platAModifier['nom']) ? htmlspecialchars($platAModifier['nom']) : ''; ?>">
                    </div>
                    <div class="form__group">
                        <textarea name="description" 
                                  required 
                                  placeholder="Description" 
                                  class="form__input"><?php echo isset($platAModifier['description']) ? htmlspecialchars($platAModifier['description']) : ''; ?></textarea>
                    </div>
                    <div class="form__group">
                        <input type="number" 
                               name="prix" 
                               required 
                               placeholder="Price" 
                               step="0.01" 
                               class="form__input"
                               value="<?php echo isset($platAModifier['prix']) ? htmlspecialchars($platAModifier['prix']) : ''; ?>">
                    </div>
                    <div class="form__group">
                        <input type="text" 
                               name="categorie" 
                               required 
                               placeholder="Category" 
                               class="form__input"
                               value="<?php echo isset($platAModifier['categorie']) ? htmlspecialchars($platAModifier['categorie']) : ''; ?>">
                    </div>
                    <div class="form__group">
                        <?php if (isset($platAModifier['url_image']) && !empty($platAModifier['url_image'])): ?>
                            <div class="current-image">
                                <img src="<?php echo htmlspecialchars($platAModifier['url_image']); ?>" alt="Current image" style="max-width: 100px;">
                                <p>Current image</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" 
                               name="image" 
                               accept="image/*" 
                               class="form__input"
                               <?php echo !isset($platAModifier) ? 'required' : ''; ?>>
                    </div>
                    <button type="submit" name="submit" class="button">
                        <?php echo isset($_GET['id']) ? 'Update Item' : 'Add Item'; ?>
                    </button>
                    <?php if (isset($_GET['id'])): ?>
                        <a href="index.php?action=admin" class="button button--secondary">Cancel Edit</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Menu Items List -->
            <div class="menu__list">
                <?php 
                $menuItems = obtenirTousLesPlats();
                if (!empty($menuItems)): 
                    foreach ($menuItems as $item): 
                ?>
                <div class="menu__item">
                    <?php if (!empty($item['url_image'])): ?>
                        <img src="<?php echo htmlspecialchars($item['url_image']); ?>" alt="" class="menu__img">
                    <?php endif; ?>
                    <div class="menu__content">
                        <h3 class="menu__name"><?php echo htmlspecialchars($item['nom']); ?></h3>
                        <p class="menu__detail"><?php echo htmlspecialchars($item['description']); ?></p>
                        <span class="menu__preci">$<?php echo htmlspecialchars($item['prix']); ?></span>
                        <div class="menu__actions">
                            <a href="index.php?action=admin&id=<?php echo $item['id']; ?>" class="button">Edit</a>
                            <a href="index.php?action=admin&supprimer=<?php echo $item['id']; ?>" 
                               class="button button--delete" 
                               onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                else: 
                ?>
                    <p>No menu items found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
$page = ob_get_clean();
?> 