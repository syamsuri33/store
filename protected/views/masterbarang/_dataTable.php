<?php
function displayTree($data)
{
    echo '<ul>';
    foreach ($data as $category) {
        echo '<li>';
        echo CHtml::link($category->Kategori, '#', array(
            'onclick' => 'selectCategory("' . $category->Kategori_ID . '", "' . CHtml::encode($category->Kategori) . '")'
        ));

        if (!empty($category->children)) {
            echo '<span class="toggle-btn" onclick="toggleChildren(this)">[+]</span>';
            echo '<div class="children" style="display:none;">';
            displayTree($category->children); 
            echo '</div>';
        }

        echo '</li>';
    }
    echo '</ul>';
}

displayTree($categoriesTree);
?>

<script>
    function toggleChildren(button) {
        var childrenDiv = button.nextElementSibling;
        if (childrenDiv.style.display === "none") {
            childrenDiv.style.display = "block";
            button.textContent = "[-]";
        } else {
            childrenDiv.style.display = "none";
            button.textContent = "[+]";
        }
    }

    function selectCategory(categoryId, categoryName) {
        document.getElementById('kategori').value = categoryName;
        document.getElementById('Kategori_ID').value = categoryId;
        $('#dataModal').modal('hide');
        $('#dataModal').on('hidden.bs.modal', function() {
            $('#Masterbarang_Vendor_ID').focus();
        });
    }
</script>