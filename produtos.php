<?php include('config.php'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciar Produtos</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNovo">Novo Produto</button>
    </div>

    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço Base</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = sqlsrv_query($conn, "SELECT * FROM BalloonProduct ORDER BY created_at DESC");
            while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['category']}</td>
                        <td>R$ " . number_format($row['base_price'], 2, ',', '.') . "</td>
                        <td>" . ($row['is_active'] ? 'Ativo' : 'Inativo') . "</td>
                        <td>
                            <a href='acoes_produto.php?del={$row['id']}' class='btn btn-sm btn-danger'>Excluir</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>