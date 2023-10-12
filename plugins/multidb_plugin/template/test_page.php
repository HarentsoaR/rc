<?php if (!empty($data)): ?>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo $row['nom']; ?></td>
                <td><?php echo $row['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <?php
        // Check if the matricule is stored in the user's session
        echo "MAT : $matricule";
        ?>
</table>
<?php else: ?>
    <p>No data found.</p>
<?php endif; ?>