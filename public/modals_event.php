<div class="modal fade" id="modalView<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalViewLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalViewLabel<?php echo $evento['id_evento']; ?>">Detalhes do Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nome do Evento:</strong> <?php echo htmlspecialchars($evento['nome_evento']); ?></p>
                <p><strong>Data do Evento:</strong> <?php echo date('d/m/Y H:i', strtotime($evento['data_evento'])); ?></p>
                <p><strong>Regras:</strong> <?php echo htmlspecialchars($evento['regras']); ?></p>
                <p><strong>Jogo:</strong> <?php echo htmlspecialchars($evento['nome_jogo']); ?></p>
                <p><strong>Organizador:</strong> <?php echo htmlspecialchars($evento['nome_org']); ?></p>
                <p><strong>Endereço:</strong> <?php echo htmlspecialchars($evento['endereco']); ?></p>
                <p><strong>Quantidade de Participantes:</strong> <?php echo $evento['qtd_participantes']; ?></p>
            </div>
            <div class="modal-footer">
                <?php if ($isPlayerLogged): ?>
                    <button type="button" class="btn btn-success">Inscrever-se</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalEditLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../includes/editar_evento.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Editar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">

                    <div class="mb-3">
                        <label for="nome_evento" class="form-label">Nome do Evento</label>
                        <input type="text" class="form-control" name="nome_evento" value="<?php echo htmlspecialchars($evento['nome_evento']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="data_evento" class="form-label">Data do Evento</label>
                        <input type="datetime-local" class="form-control" name="data_evento" value="<?php echo date('Y-m-d\TH:i', strtotime($evento['data_evento'])); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="regras" class="form-label">Regras</label>
                        <textarea class="form-control" name="regras" rows="5"><?php echo htmlspecialchars($evento['regras']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" name="rua" value="<?php echo htmlspecialchars(explode(' - ', $evento['endereco'])[0]); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" name="numero" value="<?php echo htmlspecialchars(explode(' - ', $evento['endereco'])[1]); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="setor" class="form-label">Setor</label>
                        <input type="text" class="form-control" name="setor" value="<?php echo htmlspecialchars(explode(' - ', $evento['endereco'])[2]); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" name="cidade" value="<?php echo htmlspecialchars(explode(' - ', $evento['endereco'])[3]); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" name="estado" value="<?php echo htmlspecialchars(explode(' - ', $evento['endereco'])[4]); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="pais" class="form-label">País</label>
                        <input type="text" class="form-control" name="pais" value="<?php echo htmlspecialchars(explode(' - ', $evento['endereco'])[5]); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDelete<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalDeleteLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">Excluir Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o evento <strong><?php echo htmlspecialchars($evento['nome_evento']); ?></strong>?</p>
            </div>
            <div class="modal-footer">
                <form action="../includes/delete_event.php" method="POST">
                    <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSubscribe<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalSubscribeLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSubscribeLabel">Inscrever-se no Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja se inscrever no evento <strong><?php echo htmlspecialchars($evento['nome_evento']); ?></strong>?</p>
            </div>
            <div class="modal-footer">
                <form action="../includes/inscrever_evento.php" method="POST">
                    <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                    <button type="submit" class="btn btn-success">Inscrever-se</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
