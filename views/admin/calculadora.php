<?php include(__DIR__ . '/../partials/header.php'); ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-7">
            <div class="card p-4 border-0 shadow-sm rounded-4">
                <h4 class="font-heading fw-bold mb-3" id="tituloForm">Novo Orçamento</h4>
                <form action="index.php?url=admin/salvar-calculo" method="POST" id="formCalculadora" onsubmit="return validarValorMinimo()">
                    <input type="hidden" name="id" id="edit_id_input">

                    <input type="text" name="client_name" class="form-control mb-3" placeholder="Nome do Cliente" required>
                   <input type="text" name="client_phone" class="form-control mb-3 mask-phone" 
       placeholder="(71) 98888-8888" maxlength="15" required>

                    <select name="service_type" id="service_type" class="form-select mb-3" required onchange="atualizarMinimo()">
                        <option value="" data-min="0" data-desc="">Selecione o Serviço</option>
                        <?php foreach ($servicos as $s): ?>
                            <option value="<?= $s['service_name'] ?>"
                                data-min="<?= $s['min_value'] ?>"
                                data-desc="<?= $s['service_description'] ?>">
                                <?= $s['service_name'] ?> (A partir de R$ <?= number_format($s['min_value'], 2, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <input type="text" name="name" class="form-control mb-3" placeholder="Identificação do Orçamento" required>
                    <textarea name="description" id="desc_servico" class="form-control mb-3" placeholder="Descrição do serviço (Opcional)" rows="2"></textarea>

                    <div class="row g-3">
                        <div class="col-6"><label class="small">Materiais (R$)</label>
                            <input type="number" step="0.01" name="material_cost" id="mat_cost" class="form-control" required oninput="calcularPrevia()">
                        </div>
                      

                        <div class="col-6">
                            <label class="small">Margem de Lucro (%)</label>
                            <input type="number" step="0.01" name="markup" class="form-control" id="markup"
                                value="<?= htmlspecialchars($defaults['default_markup_percentage'] ?? '0.00') ?>" required>
                        </div>

                        <div class="col-6"><label class="small">Horas</label>
                            <input type="number" step="0.1" name="labor_hours" id="hours" class="form-control" oninput="calcularPrevia()">
                        </div>
                        <!-- <div class="col-6"><label class="small">Valor Hora (R$)</label>
                            <input type="number" step="0.01" name="hourly_rate" id="rate" class="form-control" value="<?php echo $defaults['default_hourly_rate']; ?>" oninput="calcularPrevia()"></div> -->

                        <div class="col-6">
                            <label class=" small">Valor da Hora (R$)</label>
                            <input type="number" step="0.01" name="hourly_rate" class="form-control"
                                value="<?= htmlspecialchars($defaults['default_hourly_rate'] ?? '0.00') ?>" required>
                        </div>

                        <div class="col-12"><label class="small">Taxa Entrega (R$)</label>
                            <input type="number" step="0.01" name="delivery_fee" id="delivery" class="form-control" value="0" oninput="calcularPrevia()">
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 py-2 small" id="avisoMinimo" style="display:none;"></div>
                    <button type="submit" class="btn btn-primary w-100 mt-3 rounded-pill">Calcular e Salvar</button>
                </form>
            </div>
        </div>

        <div class="col-md-5">
            <h5 class="fw-bold mb-3">Últimos Orçamentos</h5>
            <div class="list-group">
                <?php
                // Use a variável $orcamentos que vem do controlador em vez de fazer a query aqui
                foreach ($orcamentos as $row): ?>
                    <div class="list-group-item list-group-item-action border-0 shadow-sm rounded-3 mb-2 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($row['client_name']); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($row['service_type']); ?></small>
                            </div>
                            <div class="text-end">
                                <div class="text-primary fw-bold">R$ <?php echo number_format($row['final_price'], 2, ',', '.'); ?></div>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-light p-1" onclick='verDetalhes(<?php echo json_encode($row); ?>)'><i class="fa-regular fa-eye"></i></button>
                                    <a href="javascript:void(0)"
                                        onclick="confirmarExclusaoGeral('index.php?url=admin/excluir-calculo&id=<?= $row['id']; ?>')"
                                        class="btn btn-sm btn-light p-1 text-danger"><i class="fa-solid fa-trash-can"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/footer.php'); ?>

<script>
    let valorMinimoAtual = 0;

    function atualizarMinimo() {
        const select = document.getElementById('service_type');
        const selectedOption = select.options[select.selectedIndex];
        valorMinimoAtual = parseFloat(selectedOption.getAttribute('data-min')) || 0;
        const descricaoServico = selectedOption.getAttribute('data-desc') || '';
        if (descricaoServico !== '') {
            document.getElementById('desc_servico').value = descricaoServico;
        }
        const aviso = document.getElementById('avisoMinimo');
        if (valorMinimoAtual > 0) {
            aviso.style.display = 'block';
            aviso.innerText = "Valor mínimo para este serviço: R$ " + valorMinimoAtual.toFixed(2).replace('.', ',');
        } else {
            aviso.style.display = 'none';
        }
    }

    function calcularPrevia() {
        const mat = parseFloat(document.getElementById('mat_cost').value) || 0;
        const markup = (parseFloat(document.getElementById('markup').value) || 0) / 100;
        const hours = parseFloat(document.getElementById('hours').value) || 0;
        const rate = parseFloat(document.getElementById('rate').value) || 0;
        const delivery = parseFloat(document.getElementById('delivery').value) || 0;
        return (mat + (hours * rate) + delivery) * (1 + markup);
    }

    function validarValorMinimo() {
        const total = calcularPrevia();
        if (total < valorMinimoAtual) {
            Swal.fire('Valor Insuficiente', "O total (R$ " + total.toFixed(2).replace('.', ',') + ") é menor que o mínimo permitido.", 'error');
            return false;
        }
        return true;
    }

    function editarOrcamento(data) {
        document.getElementById('edit_id_input').value = data.id;
        document.getElementById('tituloForm').innerText = "Editar Orçamento #" + data.id;
        document.getElementsByName('client_name')[0].value = data.client_name;
        document.getElementsByName('client_phone')[0].value = data.client_phone;
        document.getElementsByName('service_type')[0].value = data.service_type;
        document.getElementsByName('name')[0].value = data.name;
        document.getElementsByName('description')[0].value = data.description || '';
        document.getElementById('mat_cost').value = data.material_cost;
        document.getElementById('markup').value = data.markup_percentage;
        document.getElementById('hours').value = data.labor_hours;
        document.getElementById('rate').value = data.hourly_rate;
        document.getElementById('delivery').value = data.delivery_fee;
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function verDetalhes(data) {
        const margem = (parseFloat(data.markup_percentage) || 0) / 100;
        const vMaoObra = (parseFloat(data.labor_hours) || 0) * (parseFloat(data.hourly_rate) || 0);
        const mat = parseFloat(data.material_cost) || 0;
        const ent = parseFloat(data.delivery_fee) || 0;

        // Definição dos cálculos solicitados
        const vS = vMaoObra * (1 + margem);
        const vSM = (vMaoObra + mat) * (1 + margem);
        const vSE = (vMaoObra + ent) * (1 + margem);
        const vSME = (vMaoObra + mat + ent) * (1 + margem);

        const fone = (data.client_phone || "").replace(/\D/g, "");
        // whatsapp
        const textoWhatsApp = encodeURIComponent(

            `Olá *${data.client_name}*, segue orçamento: \n\n` +
            `*Serviço:* ${data.service_type} - ${data.name}\n` +
            `*Detalhamento do serviço:* ${data.description || 'N/A'}\n` +
            `*Serviço + Material + Entrega:* R$ ${vSME.toFixed(2)}\n` +
            `*Serviço + Material:* R$ ${vSM.toFixed(2)}\n` +
            `*Serviço + Entrega:* R$ ${vSE.toFixed(2)}\n` +
            `*Serviço:* R$ ${vS.toFixed(2)}\n\n` +

            `*Total:* R$ ${parseFloat(data.final_price).toFixed(2)}`
        );
        const waLink = `https://wa.me/${fone}?text=${textoWhatsApp}`;

        Swal.fire({
            title: 'Detalhes do Orçamento',
            html: `<div class="text-start small p-2">
                <p><strong>Cliente:</strong> ${data.client_name} <br>
                <strong>Telefone:</strong> ${data.client_phone || 'Não informado'}<br>
                <strong>Serviço:</strong> ${data.service_type}<br>
                <strong>Identificação:</strong> ${data.name}</p>
                <div class="bg-light p-2 rounded mb-3 border">
                    <strong>Descrição:</strong><br>${(data.description || 'Nenhuma').replace(/\n/g, '<br>')}
                </div>
                <hr>
                <table class="table table-sm">
                  <tr><td>Serviço + Material + Entrega:</td><td class="text-end">R$ ${vSME.toFixed(2)}</td></tr>
                    <tr><td>Serviço + Material:</td><td class="text-end">R$ ${vSM.toFixed(2)}</td></tr>
                    <tr><td>Serviço:</td><td class="text-end">R$ ${vS.toFixed(2)}</td></tr>
                    <tr><td>Serviço + Entrega:</td><td class="text-end">R$ ${vSE.toFixed(2)}</td></tr>
                    <tr class="text-primary fw-bold"><td>Total Final:</td><td class="text-end">R$ ${parseFloat(data.final_price).toFixed(2)}</td></tr>
                </table>
              </div>`,
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: '🖨️ PDF',
            denyButtonText: '✏️ Editar',
            cancelButtonText: 'Fechar',
            footer: fone !== "" ? `<a href="${waLink}" target="_blank" class="btn btn-success w-100 rounded-pill text-white fw-bold">💬 Enviar Resumo via WhatsApp</a>` : '',
            confirmButtonColor: '#e64a85',
            denyButtonColor: '#6c757d'
        }).then((result) => {
            // ADICIONE vSE aqui na chamada:
            if (result.isConfirmed) gerarImpressao(data, vS, vSM, vSE, vSME);
            else if (result.isDenied) editarOrcamento(data);
        });
    }

    function gerarImpressao(data, vS, vSM, vSE, vSME) {
        const win = window.open('', 'PRINT', 'height=600,width=800');
        win.document.write(`
        <html><head><title>Orçamento - ${data.client_name}</title>
        <style>
            body { font-family: sans-serif; padding: 40px; color: #333; }
            .header { text-align: center; border-bottom: 2px solid #e64a85; margin-bottom: 20px; padding-bottom: 10px; }
            .desc-box { background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin: 20px 0; border-radius: 5px; }
            .item { display: flex; justify-content: space-between; margin-bottom: 8px; border-bottom: 1px dashed #eee; padding-bottom: 5px; }
            .total { font-size: 22px; font-weight: bold; color: #e64a85; text-align: right; margin-top: 30px; }
        </style></head>
        <body>
           <div class="header"><h1>🎈 BalãoFest</h1></div>
            <p><strong>Cliente:</strong> ${data.client_name} (${data.client_phone})<br>
            <strong>Serviço:</strong> ${data.service_type} - ${data.name}</p>
            <p><strong>Descrição:</strong> ${(data.description || 'N/A').replace(/\n/g, '<br>')}</p>
            <div class="item"><span>Serviço + Material + Entrega:</span><span>R$ ${vSME.toFixed(2)}</span></div>
            <div class="item"><span>Serviço + Material:</span><span>R$ ${vSM.toFixed(2)}</span></div>
              <div class="item"><span>Serviço + Entrega:</span><span>R$ ${vSE.toFixed(2)}</span></div>
            <div class="item"><span>Serviço:</span><span>R$ ${vS.toFixed(2)}</span></div>
            <div class="total">Total Final: R$ ${parseFloat(data.final_price).toFixed(2)}</div>
            <script>window.onload = function() { window.print(); window.close(); };<\/script>
        </body></html>
    `);
        win.document.close();
    }
</script>