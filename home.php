<?php
session_start();
$nome_usuario = $_SESSION['user']['nome'] ?? 'xxx';
include_once 'conexao/db.php';

$gerenciadores = [];
$sql = "SELECT id, nome, email FROM usuario WHERE tipo_usuario = 1";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $gerenciadores[] = $row;
    }
}
$coletores = [];
$sql = "SELECT id, nome, email FROM usuario WHERE tipo_usuario = 2";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $coletores[] = $row;
    }
}
$residuos = [];
$sql = "SELECT r.id, r.titulo, r.tipo_residuo, r.quantidade, r.unidade, r.localizacao, r.preco_unidade, r.descricao, u.nome as anunciante
        FROM residuos r
        JOIN usuario u ON r.usuario_id = u.id
        ORDER BY r.created_at DESC
        LIMIT 20";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $residuos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recycling SA - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            min-height: 100vh;
            background: #f7faf7;
            background-image: url('src/auth/bg-recycling.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            /* ajuste o 0.7 para mais ou menos opacidade */
            z-index: 0;
            pointer-events: none;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .header,
        .main-content,
        .modal-bg {
            position: relative;
            z-index: 1;
        }

        .header {
            background: #185c2b;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
        }

        .header .logo {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .header .logo i {
            margin-right: 10px;
            font-size: 1.7rem;
        }

        .header .menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header .menu a,
        .header .menu button {
            background: #fff;
            color: #185c2b;
            border: none;
            border-radius: 20px;
            padding: 7px 18px;
            font-weight: 600;
            font-size: 1rem;
            margin-left: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }

        .header .menu a:hover,
        .header .menu button:hover {
            background: #e6f7e6;
        }

        .header .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-left: 18px;
        }

        .main {
            max-width: 1100px;
            margin: 32px auto 0 auto;
            padding: 0 16px;
        }

        .main h1 {
            font-size: 2rem;
            margin-bottom: 0;
            margin-top: 0;
        }

        .main .username {
            color: #185c2b;
            font-weight: 700;
            font-size: 2rem;
        }

        .main .subtitle {
            color: #444;
            margin-bottom: 24px;
            margin-top: 0;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-top: 32px;
            margin-bottom: 12px;
        }

        .mapa-bloco,
        .coletor-bloco {
            background: #d6e7db;
            border-radius: 28px;
            padding: 38px 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .mapa-bloco i {
            font-size: 2.5rem;
            color: #185c2b;
            margin-bottom: 10px;
        }

        .mapa-bloco .mapa-titulo {
            font-size: 1.2rem;
            font-weight: 700;
            color: #185c2b;
        }

        .mapa-bloco .mapa-desc {
            color: #185c2b;
            font-size: 1rem;
        }

        .btn-main {
            background: #185c2b;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 10px 32px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin: 0 0 0 16px;
            transition: background 0.2s;
        }

        .btn-main:hover {
            background: #138c3c;
        }

        .filtro {
            float: right;
            font-size: 1rem;
            color: #185c2b;
            font-weight: 600;
            margin-top: 8px;
            margin-bottom: 8px;
        }

        @media (max-width: 700px) {
            .main {
                padding: 0 4vw;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .header .menu {
                margin-top: 8px;
            }
        }

        .cards-inovacao {
            display: flex;
            gap: 18px;
            margin-top: 18px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .card-inovacao {
            background: linear-gradient(120deg, #e6f7ee 60%, #e6f2f7 100%);
            border-radius: 14px;
            box-shadow: 0 2px 8px #0001;
            border: 1.5px solid #cbe3d2;
            width: 320px;
            min-width: 260px;
            flex: 1 1 260px;
            display: flex;
            flex-direction: column;
            padding: 18px 18px 12px 18px;
            transition: box-shadow 0.2s;
        }

        .card-inovacao:hover {
            box-shadow: 0 4px 16px #0002;
        }

        .card-inovacao .icon {
            font-size: 2.2rem;
            color: #185c2b;
            margin-bottom: 10px;
            text-align: left;
        }

        .card-inovacao .card-title {
            font-weight: 700;
            font-size: 1.08rem;
            margin-bottom: 2px;
            color: #222;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-inovacao .badge {
            background: #e6f7ee;
            color: #185c2b;
            border-radius: 10px;
            font-size: 0.85rem;
            padding: 2px 10px;
            margin-left: 7px;
            font-weight: 600;
            border: 1px solid #b2d8c6;
        }

        .card-inovacao .badge-equip {
            background: #f7f3e6;
            color: #b38c1d;
            border: 1px solid #e6d8b2;
        }

        .card-inovacao .badge-pesq {
            background: #e6f7f7;
            color: #1d8cb3;
            border: 1px solid #b2d8e6;
        }

        .card-inovacao .card-date {
            color: #888;
            font-size: 0.97rem;
            margin-bottom: 6px;
        }

        .card-inovacao .card-desc {
            color: #444;
            font-size: 0.97rem;
            margin-bottom: 12px;
        }

        .card-inovacao .card-link {
            color: #185c2b;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.98rem;
            transition: text-decoration 0.2s;
        }

        .card-inovacao .card-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 1100px) {
            .cards-inovacao {
                flex-direction: column;
                gap: 12px;
            }

            .card-inovacao {
                width: 100%;
                min-width: 0;
            }
        }

        .modal-bg {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.18);
            align-items: center;
            justify-content: center;
        }

        .modal-bg.active {
            display: flex;
        }

        .custom-modal {
            background: #fff;
            border-radius: 18px;
            padding: 32px 28px 18px 28px;
            max-width: 600px;
            width: 96vw;
            box-shadow: 0 8px 32px #0002;
            position: relative;
            margin: 0 auto;
        }

        .close-modal {
            position: absolute;
            top: 12px;
            right: 18px;
            background: none;
            border: none;
            font-size: 2rem;
            color: #185c2b;
            cursor: pointer;
        }

        .form-anunciar label {
            font-weight: 600;
            margin-top: 14px;
            display: block;
        }

        .form-anunciar input,
        .form-anunciar select,
        .form-anunciar textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1.5px solid #d6e7db;
            margin-bottom: 10px;
            font-family: inherit;
            font-size: 1rem;
            background: #f7faf7;
            box-sizing: border-box;
        }

        .form-anunciar .row {
            display: flex;
            gap: 16px;
        }

        .form-anunciar .row>div {
            flex: 1;
        }

        .form-anunciar .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 10px;
        }

        .btn-cancelar {
            background: #fff;
            color: #185c2b;
            border: 1.5px solid #185c2b;
            border-radius: 20px;
            padding: 10px 28px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-cancelar:hover {
            background: #e6f7e6;
        }

        @media (max-width: 700px) {
            .custom-modal {
                padding: 18px 6vw 10px 6vw;
            }

            .form-anunciar .row {
                flex-direction: column;
                gap: 0;
            }
        }

        .carrossel-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            position: relative;
        }

        .carrossel {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 18px;
            max-width: 700px;
            padding: 12px 0;
        }

        .carrossel-card {
            min-width: 220px;
            max-width: 240px;
            background: #d6e7db;
            border-radius: 18px;
            padding: 24px 18px;
            margin: 0 4px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 8px #0001;
            text-align: center;
        }

        .carrossel-card i {
            font-size: 2rem;
            color: #185c2b;
            margin-bottom: 8px;
        }

        .carrossel-card .nome {
            font-weight: 700;
            font-size: 1.1rem;
            color: #185c2b;
            margin-bottom: 4px;
        }

        .carrossel-card .email {
            font-size: 0.98rem;
            color: #444;
            margin-bottom: 4px;
        }

        .carrossel-card .localizacao {
            font-size: 0.95rem;
            color: #666;
        }

        .carrossel-btn {
            background: #185c2b;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: 0 8px;
            transition: background 0.2s;
        }

        .carrossel-btn:hover {
            background: #138c3c;
        }

        @media (max-width: 900px) {
            .carrossel {
                max-width: 98vw;
            }
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="header">
            <div class="logo">
                <i class="fa-solid fa-recycle"></i> RECYCLING SA
            </div>
            <div class="menu">
                <a href="#">Ajuda</a>
                <button class="btn-main">Anunciar Resíduo</button>
                <a href="index.php?page=logout" class="btn-main" style="background:#fff;color:#185c2b;">Sair</a>
                <div class="avatar">
                    <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="avatar" width="38" height="38">
                </div>
            </div>
        </div>
        <div class="main">
            <h1>Olá, <span class="username"><?php echo htmlspecialchars($nome_usuario); ?></span>!</h1>
            <div class="subtitle">Anuncie seus resíduos e encontre coletores interessados.</div>
            <?php if (isset($_SESSION['user']['tipo_usuario']) && $_SESSION['user']['tipo_usuario'] == 2): ?>

            <div class="section-title">Mapa de gerenciadores <div class="filtro">Filtrar por região</div>
            </div>
            <div class="carrossel-container">
                <button class="carrossel-btn left" onclick="carrosselPrev()"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <div class="carrossel" id="carrossel-gerenciadores">
                    <?php foreach ($gerenciadores as $g): ?>
                    <div class="carrossel-card">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <div class="nome"><?php echo htmlspecialchars($g['nome']); ?></div>
                        <div class="email"><?php echo htmlspecialchars($g['email']); ?></div>
                        <div class="localizacao">
                            <?php echo htmlspecialchars($g['localizacao'] ?? 'Localização não informada'); ?></div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (empty($gerenciadores)): ?>
                    <div class="carrossel-card">
                        <div class="nome">Nenhum gerenciador encontrado.</div>
                    </div>
                    <?php endif; ?>
                </div>
                <button class="carrossel-btn right" onclick="carrosselNext()"><i
                        class="fa-solid fa-chevron-right"></i></button>
            </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user']['tipo_usuario']) && $_SESSION['user']['tipo_usuario'] == 1): ?>
            <div class="section-title">Coletores Disponíveis</div>
            <div class="carrossel-container">
                <button class="carrossel-btn left" onclick="carrosselPrevColetor()"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <div class="carrossel" id="carrossel-coletores">
                    <?php foreach ($coletores as $c): ?>
                    <div class="carrossel-card">
                        <i class="fa-solid fa-box-open"></i>
                        <div class="nome"><?php echo htmlspecialchars($c['nome']); ?></div>
                        <div class="email"><?php echo htmlspecialchars($c['email']); ?></div>
                        <div class="localizacao">
                            <?php echo htmlspecialchars($c['localizacao'] ?? 'Localização não informada'); ?></div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (empty($coletores)): ?>
                    <div class="carrossel-card">
                        <div class="nome">Nenhum coletor encontrado.</div>
                    </div>
                    <?php endif; ?>
                </div>
                <button class="carrossel-btn right" onclick="carrosselNextColetor()"><i
                        class="fa-solid fa-chevron-right"></i></button>
            </div>
            <?php endif; ?>
            <div class="section-title">Resíduos Anunciados<button class="btn-main"
                    style="float:right; margin-bottom: 1px;">Anunciar Resíduo</button></div>
            <div class="carrossel-container">
                <button class="carrossel-btn left" onclick="carrosselPrevResiduos()"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <div class="carrossel" id="carrossel-residuos">
                    <?php foreach ($residuos as $r): ?>
                    <div class="carrossel-card">
                        <i class="fa-solid fa-recycle"></i>
                        <div class="nome"><?php echo htmlspecialchars($r['titulo']); ?></div>
                        <div class="email"><?php echo htmlspecialchars($r['tipo_residuo']); ?> •
                            <?php echo htmlspecialchars($r['quantidade'] . ' ' . $r['unidade']); ?></div>
                        <div class="localizacao"><?php echo htmlspecialchars($r['localizacao']); ?></div>
                        <div class="desc" style="font-size:0.95rem;color:#444;margin:6px 0;">
                            <?php echo htmlspecialchars($r['descricao']); ?></div>
                        <div style="font-size:0.95rem;color:#185c2b;">
                            <?php if ($r['preco_unidade']): ?>
                            Preço: R$ <?php echo number_format($r['preco_unidade'],2,',','.'); ?>
                            <?php endif; ?>
                        </div>
                        <div style="font-size:0.93rem;color:#888;margin-top:4px;">Anunciante:
                            <?php echo htmlspecialchars($r['anunciante']); ?></div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (empty($residuos)): ?>
                    <div class="carrossel-card">
                        <div class="nome">Nenhum resíduo anunciado.</div>
                    </div>
                    <?php endif; ?>
                </div>
                <button class="carrossel-btn right" onclick="carrosselNextResiduos()"><i
                        class="fa-solid fa-chevron-right"></i></button>
            </div>
            <!-- Inovações em Reciclagem -->
            <div class="section-title">Inovações em Reciclagem</div>
            <div class="subtitle" style="margin-top:0;">
                Descubra as últimas tecnologias e processos para otimizar o aproveitamento de <span
                    style="color:#185c2b;text-decoration:underline;cursor:pointer;">resíduos</span>
                <a href="#"
                    style="float:right;font-size:0.98rem;color:#185c2b;font-weight:600;text-decoration:underline;margin-right:8px;">Ver
                    todas</a>
            </div>
            <div class="cards-inovacao">
                <div class="card-inovacao">
                    <div class="icon"><i class="fa-regular fa-lightbulb"></i></div>
                    <div class="card-body">
                        <div class="card-title">Transformação de plástico em combustível <span
                                class="badge">Reciclagem</span></div>
                        <div class="card-date">18/04/2025 • Dr. Ana Silva</div>
                        <div class="card-desc">Uma nova técnica para converter resíduos plásticos em combustível
                            sustentável
                        </div>
                        <a href="#" class="card-link">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="card-inovacao">
                    <div class="icon"><i class="fa-regular fa-lightbulb"></i></div>
                    <div class="card-body">
                        <div class="card-title">Compactadores solares <span class="badge badge-equip">Equipamento</span>
                        </div>
                        <div class="card-date">13/04/2025 • Eng. Roberto Carlos</div>
                        <div class="card-desc">Compactadores de resíduos que usam energia solar, reduzindo custos
                            operacionais</div>
                        <a href="#" class="card-link">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="card-inovacao">
                    <div class="icon"><i class="fa-regular fa-lightbulb"></i></div>
                    <div class="card-body">
                        <div class="card-title">Bioplásticos a partir de resíduos agrícolas <span
                                class="badge badge-pesq">Pesquisa</span></div>
                        <div class="card-date">08/04/2025 • Universidade Federal</div>
                        <div class="card-desc">Método para produzir bioplásticos utilizando resíduos da agricultura
                            local
                        </div>
                        <a href="#" class="card-link">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Anunciar Resíduo -->
        <div class="modal-bg" id="modal-anunciar" style="display:none;">
            <div class="modal custom-modal">
                <button class="close-modal" onclick="closeModalAnunciar()">&times;</button>
                <form method="POST" autocomplete="off" class="form-anunciar">
                    <h2>Anunciar Resíduo</h2>
                    <p class="subtitle">Preencha os dados abaixo para anunciar um resíduo para coleta.</p>
                    <label>Título do anúncio *</label>
                    <input type="text" name="titulo" placeholder="Ex: Lote de papelão para reciclagem" required>

                    <div class="row">
                        <div>
                            <label>Tipo de resíduo *</label>
                            <select name="tipo_residuo" required>
                                <option value="">Selecione</option>
                                <option>Plástico</option>
                                <option>Papel</option>
                                <option>Metal</option>
                                <option>Vidro</option>
                                <option>Orgânico</option>
                                <option>Eletrônico</option>
                                <option>Outro</option>
                            </select>
                        </div>
                        <div>
                            <label>Localização *</label>
                            <input type="text" name="localizacao" placeholder="Ex: São Paulo, SP" required>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <label>Quantidade *</label>
                            <input type="number" name="quantidade" placeholder="Ex: 500" required min="0" step="any">
                        </div>
                        <div>
                            <label>Unidade *</label>
                            <select name="unidade" required>
                                <option value="">Selecione</option>
                                <option>Quilogramas (kg)</option>
                                <option>Toneladas (t)</option>
                                <option>Litros (L)</option>
                                <option>Unidades</option>
                                <option>Outro</option>
                            </select>
                        </div>
                        <div>
                            <label>Preço por unidade (opcional)</label>
                            <input type="number" name="preco_unidade" placeholder="R$ Ex: 1.50" min="0" step="any">
                        </div>
                    </div>
                    <label>Descrição (opcional)</label>
                    <textarea name="descricao" rows="3"
                        placeholder="Descreva os detalhes do resíduo, como condição, características específicas, etc."></textarea>
                    <div class="actions">
                        <button type="button" class="btn-cancelar" onclick="closeModalAnunciar()">Cancelar</button>
                        <button type="submit" class="btn-main">Publicar Anúncio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function openModalAnunciar() {
            document.getElementById('modal-anunciar').classList.add('active');
            document.getElementById('modal-anunciar').style.display = 'flex';
        }

        function closeModalAnunciar() {
            document.getElementById('modal-anunciar').classList.remove('active');
            document.getElementById('modal-anunciar').style.display = 'none';
        }
        document.querySelectorAll('.btn-main').forEach(btn => {
            if (btn.textContent.includes('Anunciar Resíduo')) {
                btn.onclick = openModalAnunciar;
            }
        });
        document.querySelector('#modal-anunciar form').onsubmit = async function (e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            const resp = await fetch('consultas/residuos/insert.php', {
                method: 'POST',
                body: formData
            });
            const data = await resp.json();

            if (data.success) {
                alert(data.message);
                closeModalAnunciar();
                form.reset();
                // Aqui você pode atualizar a lista de resíduos, se desejar
            } else {
                alert(data.message);
            }
        };

        function carrosselNextColetor() {
            const c = document.getElementById('carrossel-coletores');
            c.scrollBy({
                left: 260,
                behavior: 'smooth'
            });
        }

        function carrosselPrevColetor() {
            const c = document.getElementById('carrossel-coletores');
            c.scrollBy({
                left: -260,
                behavior: 'smooth'
            });
        }

        function carrosselNextResiduos() {
            const c = document.getElementById('carrossel-residuos');
            c.scrollBy({
                left: 260,
                behavior: 'smooth'
            });
        }

        function carrosselPrevResiduos() {
            const c = document.getElementById('carrossel-residuos');
            c.scrollBy({
                left: -260,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>