(function () {
  'use strict';

  var Admin = {
    currentState: {},

    init: function () {
      var self = this;
      var last = RCEngine.loadLastTemplate();
      this.currentState = last ? JSON.parse(JSON.stringify(last)) : RCEngine.getDefaultState();

      this.refreshTemplateList();
      this.bindFormToState();
      this.renderDynamicLists();
      this.profesoresGlobal.cargar();
      this.profesoresPlantilla.renderizar();
      this.calcAhorro();
      this.updatePreviewLink();
      this.toggleIntegracionesSection();
      this.filterTipoProgramaOptions();
      this.toggleProntoPagoInput();

      document.addEventListener('input', function () {
        self.syncStateFromForm();
        self.calcAhorro();
        self.updatePreviewLink();
      });

      document.getElementById('tipoProgramaOnline').addEventListener('change', function () {
        self.syncStateFromForm();
        self.calcAhorro();
        self.updatePreviewLink();
        self.toggleIntegracionesSection();
        self.filterTipoProgramaOptions();
        self.autoFillNombreCurso();
      });

      document.getElementById('tipoPrograma').addEventListener('change', function () {
        self.syncStateFromForm();
        self.autoFillNombreCurso();
        self.updatePreviewLink();
      });

      document.getElementById('prontoPagoActivo').addEventListener('change', function () {
        self.syncStateFromForm();
        self.toggleProntoPagoInput();
      });

      document.getElementById('previewLink').addEventListener('click', function (e) {
        self.syncStateFromForm();
        self.calcAhorro();
        var name = document.getElementById('templateNameInput')?.value.trim();
        if (name) {
          RCEngine.saveTemplate(name, self.currentState);
        }
      });
    },

    toggleSection: function (header) {
      var body = header.nextElementSibling;
      if (!body) return;
      header.classList.toggle('collapsed');
      body.classList.toggle('hidden');
    },

    bindFormToState: function () {
      var self = this;
      document.querySelectorAll('[data-field]').forEach(function (el) {
        var field = el.dataset.field;
        if (self.currentState[field] !== undefined) {
          el.value = self.currentState[field];
        }
      });
      var previewFields = ['imgPromocional', 'imgPortadaVideo', 'imgInhouseDesktop', 'imgInhouseMobile'];
      previewFields.forEach(function (field) {
        var el = document.getElementById('preview-' + field);
        if (el && self.currentState[field]) {
          el.src = self.currentState[field];
        }
      });
    },

    syncStateFromForm: function () {
      var self = this;
      document.querySelectorAll('[data-field]').forEach(function (el) {
        var field = el.dataset.field;
        self.currentState[field] = el.value;
      });
      this.syncDynamicList('objetivos', ['titulo', 'descripcion']);
      this.syncDynamicList('participantes', ['titulo', 'descripcion']);
      this.syncTemarioHierarchy();
      this.autoFillNombreCurso();
    },

    syncDynamicList: function (key, fields) {
      var container = document.getElementById(key + 'List');
      if (!container) return;
      var items = [];
      container.querySelectorAll('.dynamic-item').forEach(function (item) {
        var obj = {};
        fields.forEach(function (f) {
          var input = item.querySelector('.field-' + f);
          obj[f] = input ? input.value : '';
        });
        items.push(obj);
      });
      this.currentState[key] = items;
    },

    calcAhorro: function () {
      var reg = parseFloat(document.getElementById('precioRegular')?.value) || 0;
      var ofe = parseFloat(document.getElementById('precioOferta')?.value) || 0;
      var ahorro = Math.max(0, Math.round(reg - ofe));
      var el = document.getElementById('ahorro');
      if (el) el.value = String(ahorro);
      this.currentState.ahorro = String(ahorro);
    },

    renderDynamicLists: function () {
      this.renderList('objetivos', this.currentState.objetivos || []);
      this.renderList('participantes', this.currentState.participantes || []);
      this.renderTemarioHierarchy();
    },

    renderList: function (key, items) {
      var container = document.getElementById(key + 'List');
      if (!container) return;
      container.innerHTML = '';
      var self = this;
      items.forEach(function (item, idx) {
        var el = self.createItemElement(key, item);
        container.appendChild(el);
      });
    },

    createItemElement: function (key, data) {
      var tpl = document.getElementById(key + 'Item');
      if (!tpl) return document.createElement('div');
      var clone = tpl.content.cloneNode(true);
      var item = clone.querySelector('.dynamic-item');
      Object.keys(data).forEach(function (field) {
        var input = item.querySelector('.field-' + field);
        if (input) input.value = data[field] || '';
      });
      return item;
    },

    addItem: function (key, defaults) {
      var container = document.getElementById(key + 'List');
      if (!container) return;
      this.syncStateFromForm();
      var items = this.currentState[key] || [];
      items.push(defaults ? JSON.parse(JSON.stringify(defaults)) : {});
      this.currentState[key] = items;
      this.renderList(key, items);
      this.updatePreviewLink();
    },

    removeItem: function (key, btn) {
      var item = btn.closest('.dynamic-item');
      if (!item) return;
      var container = document.getElementById(key + 'List');
      var idx = Array.from(container.children).indexOf(item);
      if (idx === -1) return;
      this.syncStateFromForm();
      var items = this.currentState[key] || [];
      items.splice(idx, 1);
      this.currentState[key] = items;
      this.renderList(key, items);
      this.updatePreviewLink();
    },

    // ======================================================================
    // TEMARIO JERÁRQUICO (cursos ➔ módulos/sesiones ➔ contenido)
    // ======================================================================

    renderTemarioHierarchy: function () {
      var container = document.getElementById('temarioHierarchy');
      if (!container) return;
      container.innerHTML = '';
      var cursos = this.currentState.cursos || [];
      var modulos = this.currentState.modulos || [];
      var self = this;

      cursos.forEach(function (curso, ci) {
        var cursoEl = self.createCursoElement(curso, ci);
        container.appendChild(cursoEl);
      });

      modulos.forEach(function (modulo, mi) {
        var modEl = self.createStandaloneModuloElement(modulo, mi);
        container.appendChild(modEl);
      });

      // Render sesiones independientes (sin curso ni módulo)
      var sesiones = this.currentState.sesiones || [];
      sesiones.forEach(function (sesion, si) {
        var sesEl = self.createStandaloneSesionElement(sesion, si);
        container.appendChild(sesEl);
      });
    },

    createCursoElement: function (curso, ci) {
      var self = this;
      var div = document.createElement('div');
      div.className = 'h-level curso-level';
      div.dataset.ci = ci;

      var totalCursos = (this.currentState.cursos || []).length;

      var header = document.createElement('div');
      header.className = 'h-header curso-header';
      header.innerHTML = '<span class="h-badge curso-badge">CURSO</span>'
        + '<button class="btn-move-sm" onclick="Admin.moveCurso(' + ci + ',-1)"' + (ci === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
        + '<button class="btn-move-sm" onclick="Admin.moveCurso(' + ci + ',1)"' + (ci === totalCursos - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
        + '<span class="h-arrow">▼</span>'
        + '<input class="h-input curso-titulo" value="' + this.escAttr(curso.titulo) + '" placeholder="Título del curso">'
        + '<button class="btn-remove-sm" onclick="Admin.removeCurso(' + ci + ')" title="Eliminar curso">✕</button>';
      header.onclick = function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
        var body = this.nextElementSibling;
        if (!body) return;
        this.classList.toggle('collapsed');
        body.classList.toggle('hidden');
      };
      div.appendChild(header);

      var body = document.createElement('div');
      body.className = 'h-body';

      var lecturas = document.createElement('div');
      lecturas.className = 'h-lecturas';
      lecturas.innerHTML = '<label>Lecturas Previas (HTML)</label>'
        + '<textarea class="h-textarea curso-lecturas" placeholder="<p><strong>Lecturas Previas Obligatorias:</strong></p>..." style="min-height:50px;">' + this.escAttr(curso.lecturasPrevias || '') + '</textarea>';
      body.appendChild(lecturas);

      var modulos = curso.modulos || [];
      var hasModulos = modulos.length > 0;

      // ── MÓDULOS ──
      var modWrap = document.createElement('div');
      modWrap.className = 'h-children modulos-wrap';

      modulos.forEach(function (modulo, mi) {
        var modEl = self.createModuloElement(modulo, ci, mi);
        modWrap.appendChild(modEl);
      });

      var addModBtn = document.createElement('button');
      addModBtn.className = 'btn-add-sm';
      addModBtn.textContent = '+ Añadir Módulo';
      addModBtn.onclick = function () { Admin.addModulo(ci); };
      modWrap.appendChild(addModBtn);
      body.appendChild(modWrap);

      // ── SESIONES DIRECTAS (solo si NO hay módulos) ──
      var sesWrap = document.createElement('div');
      sesWrap.className = 'h-children sesiones-wrap';

      if (!hasModulos) {
        var sesDirectas = curso.sesiones || [];
        sesDirectas.forEach(function (sesion, si) {
          var sesEl = self.createSesionElement(sesion, ci, -1, si);
          sesWrap.appendChild(sesEl);
        });

        var addSesBtn = document.createElement('button');
        addSesBtn.className = 'btn-add-sm';
        addSesBtn.textContent = '+ Añadir Sesión (directa)';
        addSesBtn.onclick = function () { Admin.addSesionDirect(ci); };
        sesWrap.appendChild(addSesBtn);
      }

      body.appendChild(sesWrap);
      div.appendChild(body);
      return div;
    },

    createModuloElement: function (modulo, ci, mi) {
      var self = this;
      var div = document.createElement('div');
      div.className = 'h-level modulo-level';
      div.dataset.ci = ci;
      div.dataset.mi = mi;

      var totalModulos = ((this.currentState.cursos || [])[ci]?.modulos || []).length;

      var header = document.createElement('div');
      header.className = 'h-header modulo-header';
      header.innerHTML = '<span class="h-badge modulo-badge">MÓDULO</span>'
        + '<button class="btn-move-sm" onclick="Admin.moveModulo(' + ci + ',' + mi + ',-1)"' + (mi === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
        + '<button class="btn-move-sm" onclick="Admin.moveModulo(' + ci + ',' + mi + ',1)"' + (mi === totalModulos - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
        + '<span class="h-arrow">▼</span>'
        + '<input class="h-input modulo-titulo" value="' + this.escAttr(modulo.titulo) + '" placeholder="Título del módulo">'
        + '<button class="btn-remove-sm" onclick="Admin.removeModulo(' + ci + ',' + mi + ')" title="Eliminar módulo">✕</button>';
      header.onclick = function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
        var body = this.nextElementSibling;
        if (!body) return;
        this.classList.toggle('collapsed');
        body.classList.toggle('hidden');
      };
      div.appendChild(header);

      var body = document.createElement('div');
      body.className = 'h-body';

      var sesWrap = document.createElement('div');
      sesWrap.className = 'h-children sesiones-wrap';

      var sesiones = modulo.sesiones || [];
      sesiones.forEach(function (sesion, si) {
        var sesEl = self.createSesionElement(sesion, ci, mi, si);
        sesWrap.appendChild(sesEl);
      });

      var addSesBtn = document.createElement('button');
      addSesBtn.className = 'btn-add-sm';
      addSesBtn.textContent = '+ Añadir Sesión';
      addSesBtn.onclick = function () { Admin.addSesion(ci, mi); };
      sesWrap.appendChild(addSesBtn);

      body.appendChild(sesWrap);
      div.appendChild(body);
      return div;
    },

    createStandaloneModuloElement: function (modulo, mi) {
      var self = this;
      var div = document.createElement('div');
      div.className = 'h-level curso-level standalone-modulo-level';
      div.dataset.ci = -1;
      div.dataset.mi = mi;

      var totalModulos = (this.currentState.modulos || []).length;

      var header = document.createElement('div');
      header.className = 'h-header curso-header';
      header.innerHTML = '<span class="h-badge modulo-badge">MÓDULO</span>'
        + '<button class="btn-move-sm" onclick="Admin.moveModuloStandalone(' + mi + ',-1)"' + (mi === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
        + '<button class="btn-move-sm" onclick="Admin.moveModuloStandalone(' + mi + ',1)"' + (mi === totalModulos - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
        + '<span class="h-arrow">▼</span>'
        + '<input class="h-input modulo-titulo" value="' + this.escAttr(modulo.titulo) + '" placeholder="Título del módulo">'
        + '<button class="btn-remove-sm" onclick="Admin.removeModuloStandalone(' + mi + ')" title="Eliminar módulo">✕</button>';
      header.onclick = function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
        var body = this.nextElementSibling;
        if (!body) return;
        this.classList.toggle('collapsed');
        body.classList.toggle('hidden');
      };
      div.appendChild(header);

      var body = document.createElement('div');
      body.className = 'h-body';

      var sesWrap = document.createElement('div');
      sesWrap.className = 'h-children sesiones-wrap';

      var sesiones = modulo.sesiones || [];
      sesiones.forEach(function (sesion, si) {
        var sesEl = self.createSesionElement(sesion, -1, mi, si);
        sesWrap.appendChild(sesEl);
      });

      var addSesBtn = document.createElement('button');
      addSesBtn.className = 'btn-add-sm';
      addSesBtn.textContent = '+ Añadir Sesión';
      addSesBtn.onclick = function () { Admin.addSesionStandalone(mi); };
      sesWrap.appendChild(addSesBtn);

      body.appendChild(sesWrap);
      div.appendChild(body);
      return div;
    },

    createStandaloneSesionElement: function (sesion, si) {
      var self = this;
      var div = document.createElement('div');
      div.className = 'h-level sesion-level standalone-sesion-level';
      div.dataset.ci = -2;
      div.dataset.mi = -1;
      div.dataset.si = si;

      var totalSesiones = (this._getSesionesByPath(-2, -1) || []).length;

      var header = document.createElement('div');
      header.className = 'h-header sesion-header';
      header.innerHTML = '<span class="h-badge sesion-badge">SESIÓN</span>'
        + '<button class="btn-move-sm" onclick="Admin.moveSesion(-2,-1,' + si + ',-1)"' + (si === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
        + '<button class="btn-move-sm" onclick="Admin.moveSesion(-2,-1,' + si + ',1)"' + (si === totalSesiones - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
        + '<span class="h-arrow">▼</span>'
        + '<input class="h-input sesion-titulo" value="' + this.escAttr(sesion.titulo) + '" placeholder="Título de la sesión">'
        + '<button class="btn-remove-sm" onclick="Admin.removeSesionStandaloneItem(' + si + ')" title="Eliminar sesión">✕</button>';
      header.onclick = function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
        var body = this.nextElementSibling;
        if (!body) return;
        this.classList.toggle('collapsed');
        body.classList.toggle('hidden');
      };
      div.appendChild(header);

      var body = document.createElement('div');
      body.className = 'h-body';

      var contWrap = document.createElement('div');
      contWrap.className = 'h-contenido-items';
      contWrap.id = 'contenido--2--1-' + si;

      var raw = sesion.contenido || [];
      var items = typeof raw === 'string' ? [] : raw;
      items.forEach(function (item, ii) {
        var itemEl = self.createContenidoItemElement(item, -2, -1, si, ii);
        contWrap.appendChild(itemEl);
      });

      var addBar = document.createElement('div');
      addBar.className = 'h-add-bar';
      addBar.innerHTML = '<button class="btn-add-xs" onclick="Admin.addContenidoItem(-2,-1,' + si + ',\'subtitulo\')">+ Subtítulo</button>'
        + '<button class="btn-add-xs" onclick="Admin.addContenidoItem(-2,-1,' + si + ',\'texto\')">+ Texto</button>'
        + '<button class="btn-add-xs" onclick="Admin.addContenidoItem(-2,-1,' + si + ',\'lista\')">+ Lista</button>';
      contWrap.appendChild(addBar);

      body.appendChild(contWrap);
      div.appendChild(body);
      return div;
    },

    createSesionElement: function (sesion, ci, mi, si) {
      var self = this;
      var div = document.createElement('div');
      div.className = 'h-level sesion-level';
      div.dataset.ci = ci;
      div.dataset.mi = mi;
      div.dataset.si = si;

      var removeFn;
      if (ci === -2) {
        removeFn = 'Admin.removeSesionStandaloneItem(' + si + ')';
      } else if (ci === -1) {
        removeFn = 'Admin.removeSesionStandalone(' + mi + ',' + si + ')';
      } else if (mi >= 0) {
        removeFn = 'Admin.removeSesion(' + ci + ',' + mi + ',' + si + ')';
      } else {
        removeFn = 'Admin.removeSesionDirect(' + ci + ',' + si + ')';
      }

      var totalSesiones = (this._getSesionesByPath(ci, mi) || []).length;

      var header = document.createElement('div');
      header.className = 'h-header sesion-header';
      header.innerHTML = '<span class="h-badge sesion-badge">SESIÓN</span>'
        + '<button class="btn-move-sm" onclick="Admin.moveSesion(' + ci + ',' + mi + ',' + si + ',-1)"' + (si === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
        + '<button class="btn-move-sm" onclick="Admin.moveSesion(' + ci + ',' + mi + ',' + si + ',1)"' + (si === totalSesiones - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
        + '<span class="h-arrow">▼</span>'
        + '<input class="h-input sesion-titulo" value="' + this.escAttr(sesion.titulo) + '" placeholder="Título de la sesión">'
        + '<button class="btn-remove-sm" onclick="' + removeFn + '" title="Eliminar sesión">✕</button>';
      header.onclick = function (e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.tagName === 'TEXTAREA') return;
        var body = this.nextElementSibling;
        if (!body) return;
        this.classList.toggle('collapsed');
        body.classList.toggle('hidden');
      };
      div.appendChild(header);

      var body = document.createElement('div');
      body.className = 'h-body';

      var contWrap = document.createElement('div');
      contWrap.className = 'h-contenido-items';
      contWrap.id = 'contenido-' + ci + '-' + mi + '-' + si;

      var raw = sesion.contenido || [];
      var items = typeof raw === 'string' ? [] : raw;
      items.forEach(function (item, ii) {
        var itemEl = self.createContenidoItemElement(item, ci, mi, si, ii);
        contWrap.appendChild(itemEl);
      });

      var addBar = document.createElement('div');
      addBar.className = 'h-add-bar';
      addBar.innerHTML = '<button class="btn-add-xs" onclick="Admin.addContenidoItem(' + ci + ',' + mi + ',' + si + ',\'subtitulo\')">+ Subtítulo</button>'
        + '<button class="btn-add-xs" onclick="Admin.addContenidoItem(' + ci + ',' + mi + ',' + si + ',\'texto\')">+ Texto</button>'
        + '<button class="btn-add-xs" onclick="Admin.addContenidoItem(' + ci + ',' + mi + ',' + si + ',\'lista\')">+ Lista</button>';
      contWrap.appendChild(addBar);

      body.appendChild(contWrap);
      div.appendChild(body);
      return div;
    },

    createContenidoItemElement: function (item, ci, mi, si, ii) {
      var self = this;
      var badgeClass = item.tipo === 'subtitulo' ? 'subtitulo-badge'
        : item.tipo === 'texto' ? 'texto-badge'
        : 'lista-badge';

      var totalItems = (this._getSesionesByPath(ci, mi)?.[si]?.contenido || []).length;

      var div = document.createElement('div');
      div.className = 'h-contenido-item';
      div.dataset.ii = ii;

      var headerRow = document.createElement('div');
      headerRow.className = 'h-contenido-header';
      headerRow.innerHTML = '<span class="h-badge ' + badgeClass + '">' + item.tipo.toUpperCase() + '</span>'
        + '<button class="btn-move-xs" onclick="Admin.moveContenidoItem(' + ci + ',' + mi + ',' + si + ',' + ii + ',-1)"' + (ii === 0 ? ' disabled' : '') + ' title="Subir">▲</button>'
        + '<button class="btn-move-xs" onclick="Admin.moveContenidoItem(' + ci + ',' + mi + ',' + si + ',' + ii + ',1)"' + (ii === totalItems - 1 ? ' disabled' : '') + ' title="Bajar">▼</button>'
        + '<input class="h-input contenido-texto" value="' + this.escAttr(item.texto) + '" placeholder="Texto del ' + item.tipo + '">'
        + '<button class="btn-remove-xs" onclick="Admin.removeContenidoItem(' + ci + ',' + mi + ',' + si + ',' + ii + ')" title="Eliminar">✕</button>';
      div.appendChild(headerRow);

      // For lista (and backward compat sublista): show nested elementos
      if (item.tipo === 'lista' || item.tipo === 'sublista') {
        var elemWrap = document.createElement('div');
        elemWrap.className = 'h-elementos-wrap';
        elemWrap.dataset.ci = ci;
        elemWrap.dataset.mi = mi;
        elemWrap.dataset.si = si;
        elemWrap.dataset.ii = ii;

        var elementos = item.elementos || [];
        elementos.forEach(function (elem, ei) {
          var elemRow = document.createElement('div');
          elemRow.className = 'h-elemento-row';
          elemRow.innerHTML = '<span class="h-elem-bullet"></span>'
            + '<input class="h-input elemento-texto" value="' + self.escAttr(elem) + '" placeholder="Elemento">'
            + '<button class="btn-remove-xs" onclick="Admin.removeListaElement(' + ci + ',' + mi + ',' + si + ',' + ii + ',' + ei + ')" title="Eliminar">✕</button>';
          elemWrap.appendChild(elemRow);
        });

        var addBtn = document.createElement('button');
        addBtn.className = 'btn-add-xs';
        addBtn.textContent = '+ elemento';
        addBtn.onclick = function () { Admin.addListaElement(ci, mi, si, ii); };
        elemWrap.appendChild(addBtn);

        div.appendChild(elemWrap);
      }

      return div;
    },

    // ─── CRUD: CURSOS ───

    addCurso: function () {
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      cursos.push({ titulo: 'CURSO ' + (cursos.length + 1) + ': NUEVO CURSO', lecturasPrevias: '', modulos: [], sesiones: [] });
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeCurso: function (ci) {
      if (!confirm('¿Eliminar este curso y todo su contenido?')) return;
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      cursos.splice(ci, 1);
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    // ─── CRUD: MÓDULOS ───

    addModulo: function (ci) {
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return;
      var modulos = cursos[ci].modulos || [];
      modulos.push({ titulo: 'MÓDULO ' + (modulos.length + 1) + ': NUEVO MÓDULO', sesiones: [] });
      cursos[ci].modulos = modulos;
      // Clear direct sesiones when switching to módulos
      cursos[ci].sesiones = [];
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeModulo: function (ci, mi) {
      if (!confirm('¿Eliminar este módulo y todas sus sesiones?')) return;
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return;
      var modulos = cursos[ci].modulos || [];
      modulos.splice(mi, 1);
      cursos[ci].modulos = modulos;
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    // ─── CRUD: SESIONES ───

    addSesion: function (ci, mi) {
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return;
      var modulos = cursos[ci].modulos || [];
      if (!modulos[mi]) return;
      var sesiones = modulos[mi].sesiones || [];
      sesiones.push({ titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
      modulos[mi].sesiones = sesiones;
      cursos[ci].modulos = modulos;
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    addSesionDirect: function (ci) {
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return;
      var sesiones = cursos[ci].sesiones || [];
      sesiones.push({ titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
      cursos[ci].sesiones = sesiones;
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeSesion: function (ci, mi, si) {
      if (!confirm('¿Eliminar esta sesión?')) return;
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return;
      var modulos = cursos[ci].modulos || [];
      if (!modulos[mi]) return;
      var sesiones = modulos[mi].sesiones || [];
      sesiones.splice(si, 1);
      modulos[mi].sesiones = sesiones;
      cursos[ci].modulos = modulos;
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeSesionDirect: function (ci, si) {
      if (!confirm('¿Eliminar esta sesión?')) return;
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return;
      var sesiones = cursos[ci].sesiones || [];
      sesiones.splice(si, 1);
      cursos[ci].sesiones = sesiones;
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    // ─── BOTONES GLOBALES (top-level) ───

    addModuloGlobal: function () {
      this.syncStateFromForm();
      var modulos = this.currentState.modulos || [];
      modulos.push({ titulo: 'MÓDULO ' + (modulos.length + 1) + ': NUEVO MÓDULO', sesiones: [] });
      this.currentState.modulos = modulos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    addSesionGlobal: function () {
      this.syncStateFromForm();
      var modulos = this.currentState.modulos || [];

      if (modulos.length > 0) {
        // Add to last standalone módulo
        var mi = modulos.length - 1;
        var sesiones = modulos[mi].sesiones || [];
        sesiones.push({ titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
        modulos[mi].sesiones = sesiones;
        this.currentState.modulos = modulos;
      } else {
        // Fallback to cursos
        var cursos = this.currentState.cursos || [];
        if (cursos.length > 0) {
          var ci = cursos.length - 1;
          var cModulos = cursos[ci].modulos || [];
          if (cModulos.length > 0) {
            var mi = cModulos.length - 1;
            var sesiones = cModulos[mi].sesiones || [];
            sesiones.push({ titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
            cModulos[mi].sesiones = sesiones;
            cursos[ci].modulos = cModulos;
          } else {
            var sesiones = cursos[ci].sesiones || [];
            sesiones.push({ titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
            cursos[ci].sesiones = sesiones;
          }
          this.currentState.cursos = cursos;
        } else {
          // No cursos, no modulos → standalone sesion
          var sesiones = this.currentState.sesiones || [];
          sesiones.push({ titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
          this.currentState.sesiones = sesiones;
        }
      }

      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    addSesionStandalone: function (mi) {
      this.syncStateFromForm();
      var modulos = this.currentState.modulos || [];
      if (!modulos[mi]) return;
      var sesiones = modulos[mi].sesiones || [];
      sesiones.push({ titulo: 'SESIÓN ' + (sesiones.length + 1) + ': NUEVA SESIÓN', contenido: [] });
      modulos[mi].sesiones = sesiones;
      this.currentState.modulos = modulos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeModuloStandalone: function (mi) {
      if (!confirm('¿Eliminar este módulo y todas sus sesiones?')) return;
      this.syncStateFromForm();
      var modulos = this.currentState.modulos || [];
      modulos.splice(mi, 1);
      this.currentState.modulos = modulos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeSesionStandalone: function (mi, si) {
      if (!confirm('¿Eliminar esta sesión?')) return;
      this.syncStateFromForm();
      var modulos = this.currentState.modulos || [];
      if (!modulos[mi]) return;
      var sesiones = modulos[mi].sesiones || [];
      sesiones.splice(si, 1);
      modulos[mi].sesiones = sesiones;
      this.currentState.modulos = modulos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeSesionStandaloneItem: function (si) {
      if (!confirm('¿Eliminar esta sesión?')) return;
      this.syncStateFromForm();
      var sesiones = this.currentState.sesiones || [];
      sesiones.splice(si, 1);
      this.currentState.sesiones = sesiones;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    // ─── CRUD: CONTENIDO ITEMS ───

    _getSesionesByPath: function (ci, mi) {
      if (ci === -2) {
        return this.currentState.sesiones || null;
      }
      if (ci === -1) {
        var modulos = this.currentState.modulos || [];
        return modulos[mi] ? modulos[mi].sesiones || [] : null;
      }
      if (mi >= 0) {
        var cursos = this.currentState.cursos || [];
        if (!cursos[ci]) return null;
        var modulos = cursos[ci].modulos || [];
        return modulos[mi] ? modulos[mi].sesiones || [] : null;
      }
      var cursos = this.currentState.cursos || [];
      return cursos[ci] ? cursos[ci].sesiones || [] : null;
    },

    _setSesionesByPath: function (ci, mi, sesiones) {
      if (ci === -2) {
        this.currentState.sesiones = sesiones;
      } else if (ci === -1) {
        var modulos = this.currentState.modulos || [];
        if (modulos[mi]) modulos[mi].sesiones = sesiones;
        this.currentState.modulos = modulos;
      } else if (mi >= 0) {
        var cursos = this.currentState.cursos || [];
        if (cursos[ci] && cursos[ci].modulos[mi]) cursos[ci].modulos[mi].sesiones = sesiones;
      } else {
        var cursos = this.currentState.cursos || [];
        if (cursos[ci]) cursos[ci].sesiones = sesiones;
      }
    },

    addContenidoItem: function (ci, mi, si, tipo) {
      this.syncStateFromForm();
      var sesiones = this._getSesionesByPath(ci, mi);
      if (!sesiones || !sesiones[si]) return;

      var contenido = sesiones[si].contenido || [];
      contenido.push({ tipo: tipo, texto: '' });
      sesiones[si].contenido = contenido;
      this._setSesionesByPath(ci, mi, sesiones);

      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeContenidoItem: function (ci, mi, si, ii) {
      this.syncStateFromForm();
      var sesiones = this._getSesionesByPath(ci, mi);
      if (!sesiones || !sesiones[si]) return;

      var contenido = sesiones[si].contenido || [];
      contenido.splice(ii, 1);
      sesiones[si].contenido = contenido;
      this._setSesionesByPath(ci, mi, sesiones);

      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    // ─── CRUD: ELEMENTOS DE LISTA/SUBLISTA ───

    addListaElement: function (ci, mi, si, ii) {
      this.syncStateFromForm();
      var sesiones = this._getSesionesByPath(ci, mi);
      if (!sesiones || !sesiones[si]) return;
      var contenido = sesiones[si].contenido || [];
      if (!contenido[ii]) return;
      var elementos = contenido[ii].elementos || [];
      elementos.push('');
      contenido[ii].elementos = elementos;
      sesiones[si].contenido = contenido;
      this._setSesionesByPath(ci, mi, sesiones);
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    removeListaElement: function (ci, mi, si, ii, ei) {
      this.syncStateFromForm();
      var sesiones = this._getSesionesByPath(ci, mi);
      if (!sesiones || !sesiones[si]) return;
      var contenido = sesiones[si].contenido || [];
      if (!contenido[ii]) return;
      var elementos = contenido[ii].elementos || [];
      elementos.splice(ei, 1);
      contenido[ii].elementos = elementos;
      sesiones[si].contenido = contenido;
      this._setSesionesByPath(ci, mi, sesiones);
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    // ─── MOVE / REORDER ───

    _moveArrayItem: function (arr, idx, dir) {
      var target = idx + dir;
      if (target < 0 || target >= arr.length) return;
      var tmp = arr[idx];
      arr[idx] = arr[target];
      arr[target] = tmp;
    },

    moveCurso: function (ci, dir) {
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      this._moveArrayItem(cursos, ci, dir);
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    moveModulo: function (ci, mi, dir) {
      this.syncStateFromForm();
      var cursos = this.currentState.cursos || [];
      if (!cursos[ci]) return;
      var modulos = cursos[ci].modulos || [];
      this._moveArrayItem(modulos, mi, dir);
      cursos[ci].modulos = modulos;
      this.currentState.cursos = cursos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    moveModuloStandalone: function (mi, dir) {
      this.syncStateFromForm();
      var modulos = this.currentState.modulos || [];
      this._moveArrayItem(modulos, mi, dir);
      this.currentState.modulos = modulos;
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    moveSesion: function (ci, mi, si, dir) {
      this.syncStateFromForm();
      var sesiones = this._getSesionesByPath(ci, mi);
      if (!sesiones) return;
      this._moveArrayItem(sesiones, si, dir);
      this._setSesionesByPath(ci, mi, sesiones);
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    moveContenidoItem: function (ci, mi, si, ii, dir) {
      this.syncStateFromForm();
      var sesiones = this._getSesionesByPath(ci, mi);
      if (!sesiones || !sesiones[si]) return;
      var contenido = sesiones[si].contenido || [];
      this._moveArrayItem(contenido, ii, dir);
      sesiones[si].contenido = contenido;
      this._setSesionesByPath(ci, mi, sesiones);
      this.renderTemarioHierarchy();
      this.updatePreviewLink();
    },

    // ─── SYNC HIERARCHY FROM DOM ───

    syncTemarioHierarchy: function () {
      var container = document.getElementById('temarioHierarchy');
      if (!container) return;
      var cursos = [];
      var modulos = [];

      container.querySelectorAll(':scope > .curso-level').forEach(function (cursoEl) {
        // Skip standalone modulos (ci = -1)
        if (cursoEl.dataset.ci === '-1') return;

        var titulo = cursoEl.querySelector('.curso-titulo')?.value || '';
        var lecturas = cursoEl.querySelector('.curso-lecturas')?.value || '';
        var modulosCurso = [];
        var sesiones = [];

        var modEls = cursoEl.querySelectorAll('.modulos-wrap > .modulo-level');
        if (modEls.length > 0) {
          modEls.forEach(function (modEl) {
            var modTitulo = modEl.querySelector('.modulo-titulo')?.value || '';
            var modSesiones = [];

            modEl.querySelectorAll('.sesiones-wrap > .sesion-level').forEach(function (sesEl) {
              modSesiones.push(Admin._readSesionFromDOM(sesEl));
            });

            modulosCurso.push({ titulo: modTitulo, sesiones: modSesiones });
          });
        }

        if (modulosCurso.length === 0) {
          var sesEls = cursoEl.querySelectorAll('.sesiones-wrap > .sesion-level');
          sesEls.forEach(function (sesEl) {
            sesiones.push(Admin._readSesionFromDOM(sesEl));
          });
        }

        cursos.push({ titulo: titulo, lecturasPrevias: lecturas, modulos: modulosCurso, sesiones: sesiones });
      });

      // Read standalone modulos
      container.querySelectorAll(':scope > .standalone-modulo-level').forEach(function (modEl) {
        var titulo = modEl.querySelector('.modulo-titulo')?.value || '';
        var sesiones = [];

        modEl.querySelectorAll('.sesiones-wrap > .sesion-level').forEach(function (sesEl) {
          sesiones.push(Admin._readSesionFromDOM(sesEl));
        });

        modulos.push({ titulo: titulo, sesiones: sesiones });
      });

      // Read standalone sesiones
      var standaloneSesiones = [];
      container.querySelectorAll(':scope > .standalone-sesion-level').forEach(function (sesEl) {
        standaloneSesiones.push(Admin._readSesionFromDOM(sesEl));
      });

      this.currentState.cursos = cursos;
      this.currentState.modulos = modulos;
      this.currentState.sesiones = standaloneSesiones;
    },

    _readSesionFromDOM: function (sesEl) {
      var sesTitulo = sesEl.querySelector('.sesion-titulo')?.value || '';
      var contenido = [];

      var contWrap = sesEl.querySelector('.h-contenido-items');
      if (contWrap) {
        contWrap.querySelectorAll('.h-contenido-item').forEach(function (itemEl) {
          var badge = itemEl.querySelector('.h-badge');
          var tipo = badge ? badge.textContent.toLowerCase() : 'lista';
          var texto = itemEl.querySelector('.contenido-texto')?.value || '';
          var item = { tipo: tipo, texto: texto };

          if (tipo === 'lista' || tipo === 'sublista') {
            var elementos = [];
            itemEl.querySelectorAll('.elemento-texto').forEach(function (el) {
              elementos.push(el.value);
            });
            item.elementos = elementos;
          }

          contenido.push(item);
        });
      }

      return { titulo: sesTitulo, contenido: contenido };
    },

    // ─── TEMPLATE MANAGEMENT ───

    getCurrentTemplateName: function () {
      return document.getElementById('templateSelect')?.value || '';
    },

    refreshTemplateList: function () {
      var sel = document.getElementById('templateSelect');
      if (!sel) return;
      var names = RCEngine.listTemplates();
      sel.innerHTML = '<option value="">-- Nueva plantilla --</option>';
      names.forEach(function (name) {
        var opt = document.createElement('option');
        opt.value = name;
        opt.textContent = name;
        sel.appendChild(opt);
      });
      var last = localStorage.getItem('rc-last-template') || '';
      if (last && names.indexOf(last) !== -1) {
        sel.value = last;
        document.getElementById('templateNameInput').value = last;
      }
    },

    loadSelected: function () {
      var name = this.getCurrentTemplateName();
      if (!name) return;
      var saved = RCEngine.loadTemplate(name);
      if (saved) {
        this.currentState = JSON.parse(JSON.stringify(saved));
        this.bindFormToState();
        this.renderDynamicLists();
        this.profesoresPlantilla.renderizar();
        this.calcAhorro();
        this.updatePreviewLink();
        this.toggleIntegracionesSection();
        this.filterTipoProgramaOptions();
        this.toggleProntoPagoInput();
        this.autoFillNombreCurso();
        document.getElementById('templateNameInput').value = name;
        this.showToast('Plantilla "' + name + '" cargada', 'success');
      }
    },

    saveCurrent: function () {
      this.syncStateFromForm();
      this.calcAhorro();
      var name = document.getElementById('templateNameInput')?.value.trim();
      if (!name) {
        this.showToast('Ingresa un nombre para la plantilla', 'error');
        return;
      }
      RCEngine.saveTemplate(name, this.currentState);
      this.refreshTemplateList();
      document.getElementById('templateSelect').value = name;
      this.updatePreviewLink();
      this.showToast('Plantilla "' + name + '" guardada', 'success');
    },

    deleteCurrent: function () {
      var name = this.getCurrentTemplateName();
      if (!name) {
        this.showToast('Selecciona una plantilla para eliminar', 'error');
        return;
      }
      if (!confirm('¿Eliminar la plantilla "' + name + '"?')) return;
      RCEngine.deleteTemplate(name);
      this.refreshTemplateList();
      this.currentState = RCEngine.getDefaultState();
      this.bindFormToState();
      this.renderDynamicLists();
      this.profesoresPlantilla.renderizar();
      this.calcAhorro();
      this.updatePreviewLink();
      this.filterTipoProgramaOptions();
      this.toggleProntoPagoInput();
      this.showToast('Plantilla "' + name + '" eliminada', 'success');
    },

    updatePreviewLink: function () {
      this.syncStateFromForm();
      this.calcAhorro();
      var name = document.getElementById('templateNameInput')?.value.trim();
      if (name) {
        RCEngine.saveTemplate(name, this.currentState);
      }
      var link = document.getElementById('previewLink');
      if (!link) return;
      link.href = name ? './index.html?template=' + encodeURIComponent(name) : './index.html';
    },

    showToast: function (msg, type) {
      var toast = document.getElementById('toast');
      if (!toast) return;
      toast.textContent = msg;
      toast.className = 'toast ' + type + ' show';
      setTimeout(function () {
        toast.classList.remove('show');
      }, 2500);
    },

    toggleIntegracionesSection: function () {
      var section = document.getElementById('integraciones-section');
      if (!section) return;
      section.style.display = this.currentState.tipoProgramaOnline === 'si' ? 'none' : '';
    },

    filterTipoProgramaOptions: function () {
      var isOnline = this.currentState.tipoProgramaOnline === 'si';
      var sel = document.getElementById('tipoPrograma');
      if (!sel) return;
      for (var i = 0; i < sel.options.length; i++) {
        var opt = sel.options[i];
        var hasOnline = opt.value.indexOf('Online') !== -1;
        opt.disabled = isOnline ? hasOnline === false : hasOnline === true;
      }
      if (sel.selectedOptions[0] && sel.selectedOptions[0].disabled) {
        sel.value = '';
        this.currentState.tipoPrograma = '';
      }
    },

    autoFillNombreCurso: function () {
      var tp = this.currentState.tipoPrograma || '';
      var title = this.currentState.tituloCursoLargo || '';

      var base = tp.indexOf('Curso') === 0 ? 'Curso' : tp.indexOf('Diplomado') === 0 ? 'Diploma' : '';
      if (!base) return;

      var cleanTitle = title;
      if (cleanTitle.indexOf('Curso ') === 0) cleanTitle = cleanTitle.substring(6);
      else if (cleanTitle.indexOf('Diplomado ') === 0) cleanTitle = cleanTitle.substring(10);

      this.currentState.nombreCursoSheets = base + ' ' + cleanTitle;
    },

    toggleProntoPagoInput: function () {
      var input = document.getElementById('precioProntoPago');
      if (!input) return;
      input.disabled = this.currentState.prontoPagoActivo !== 'si';
    },

    // ─── SUBIR IMAGEN (GENÉRICO) ───

    _uploadTarget: null,

    mostrarModalImagen: function (fieldId, destino) {
      Admin._uploadTarget = { fieldId: fieldId, destino: destino };
      document.getElementById('modal-upload-file').value = '';
      document.getElementById('modal-upload-nombre').value = '';
      document.getElementById('modal-upload-preview').src = './img/promocion.jpg';
      delete document.getElementById('modal-upload-preview').dataset.objectUrl;
      delete document.getElementById('modal-upload-preview').dataset.hasFile;
      var modal = new bootstrap.Modal(document.getElementById('modalSubirImagen'));
      modal.show();
    },

    previewImagen: function (input) {
      var file = input.files[0];
      if (!file) return;
      if (!file.type.startsWith('image/')) {
        Admin.showToast('El archivo debe ser una imagen', 'error');
        input.value = '';
        return;
      }
      if (file.size > 2.5 * 1024 * 1024) {
        Admin.showToast('La imagen no debe superar los 2.5MB', 'error');
        input.value = '';
        return;
      }
      var preview = document.getElementById('modal-upload-preview');
      if (preview.dataset.objectUrl) {
        URL.revokeObjectURL(preview.dataset.objectUrl);
      }
      var url = URL.createObjectURL(file);
      preview.src = url;
      preview.dataset.objectUrl = url;
      preview.dataset.hasFile = '1';
      var nameWithoutExt = file.name.replace(/\.[^.]+$/, '');
      document.getElementById('modal-upload-nombre').value = nameWithoutExt;
    },

    subirImagen: async function () {
      var target = Admin._uploadTarget;
      if (!target) {
        Admin.showToast('Error: no hay destino configurado', 'error');
        return;
      }
      var fileInput = document.getElementById('modal-upload-file');
      if (!fileInput.files[0]) {
        Admin.showToast('Selecciona una imagen primero', 'error');
        return;
      }
      var nombre = document.getElementById('modal-upload-nombre').value.trim();
      if (!nombre) {
        Admin.showToast('Ingresa un nombre personalizado para la imagen', 'error');
        return;
      }
      var formData = new FormData();
      formData.append('file', fileInput.files[0]);
      formData.append('nombre', nombre);
      formData.append('destino', target.destino);
      try {
        var resp = await fetch('upload.php', { method: 'POST', body: formData });
        var result = await resp.json();
        if (result.url) {
          document.getElementById(target.fieldId).value = result.url;
          var previewEl = document.getElementById('preview-' + target.fieldId);
          if (previewEl) previewEl.src = result.url;
          Admin.syncStateFromForm();
          bootstrap.Modal.getInstance(document.getElementById('modalSubirImagen')).hide();
          Admin.showToast('Imagen subida correctamente', 'success');
        } else {
          Admin.showToast('Error: ' + (result.error || 'desconocido'), 'error');
        }
      } catch (e) {
        Admin.showToast('Error al subir imagen: ' + e.message, 'error');
      }
    },

    // ─── SELECCIONAR IMAGEN SUBIDA (GENÉRICO) ───

    _selectTarget: null,
    _selImgData: [],

    mostrarModalSeleccionar: function (fieldId, carpeta) {
      Admin._selectTarget = { fieldId: fieldId, carpeta: carpeta };
      var grid = document.getElementById('sel-img-grid');
      grid.innerHTML = '<p style="color:#6b7280;">Cargando...</p>';
      document.getElementById('sel-img-search').value = '';
      delete grid.dataset.selected;
      (async function () {
        try {
          var resp = await fetch('listar-imagenes.php?carpeta=' + encodeURIComponent(carpeta));
          var data = await resp.json();
          Admin._selImgData = data;
          Admin._renderImgGrid(data);
        } catch (e) {
          grid.innerHTML = '<p style="color:#ef4444;">Error al cargar imágenes</p>';
          return;
        }
        var modal = new bootstrap.Modal(document.getElementById('modalSeleccionarImagen'));
        modal.show();
      })();
    },

    _renderImgGrid: function (images) {
      var grid = document.getElementById('sel-img-grid');
      if (!images.length) {
        grid.innerHTML = '<p style="color:#6b7280;">No hay imágenes subidas</p>';
        return;
      }
      grid.innerHTML = '';
      images.forEach(function (img) {
        var card = document.createElement('div');
        card.className = 'img-card';
        card.dataset.url = img.url;
        card.innerHTML = '<img src="' + img.url + '" alt="' + img.name + '"><span>' + img.name + '</span>';
        card.onclick = function () {
          grid.querySelectorAll('.img-card').forEach(function (c) { c.classList.remove('selected'); });
          card.classList.add('selected');
          grid.dataset.selected = img.url;
        };
        grid.appendChild(card);
      });
    },

    filtrarImagenes: function (query) {
      if (!Admin._selImgData) return;
      var q = query.toLowerCase().trim();
      var filtered = Admin._selImgData.filter(function (img) {
        return img.name.toLowerCase().includes(q);
      });
      Admin._renderImgGrid(filtered);
    },

    seleccionarImagen: function () {
      var target = Admin._selectTarget;
      if (!target) {
        Admin.showToast('Error: no hay destino configurado', 'error');
        return;
      }
      var url = document.getElementById('sel-img-grid').dataset.selected;
      if (!url) {
        Admin.showToast('Selecciona una imagen primero', 'error');
        return;
      }
      document.getElementById(target.fieldId).value = url;
      var previewEl = document.getElementById('preview-' + target.fieldId);
      if (previewEl) previewEl.src = url;
      Admin.syncStateFromForm();
      bootstrap.Modal.getInstance(document.getElementById('modalSeleccionarImagen')).hide();
      Admin.showToast('Imagen seleccionada', 'success');
    },

    // ─── WRAPPERS RETROCOMPATIBILIDAD ───

    mostrarModalImagenPromocional: function () {
      Admin.mostrarModalImagen('imgPromocional', 'imagenes-promocionales');
    },

    subirImagenPromocional: function () {
      Admin.subirImagen();
    },

    mostrarModalSeleccionarImagen: function () {
      Admin.mostrarModalSeleccionar('imgPromocional', 'imagenes-promocionales');
    },

    previewImagenPromocional: function (input) {
      Admin.previewImagen(input);
    },

    switchTab: function (tabId) {
      document.querySelectorAll('.tab-content').forEach(function (el) {
        el.classList.remove('active');
      });
      document.querySelectorAll('.tab-btn').forEach(function (el) {
        el.classList.remove('active');
      });
      document.getElementById(tabId).classList.add('active');
      document.querySelector('.tab-btn[data-tab="' + tabId + '"]').classList.add('active');
      if (tabId === 'tab-profesores') {
        this.profesoresGlobal.renderizar();
      }
    },

    profesoresGlobal: {
      _data: [],
      _editIdx: -1,

      cargar: function () {
        try {
          var raw = localStorage.getItem('rc-profesores');
          this._data = raw ? JSON.parse(raw) : [];
        } catch (e) {
          this._data = [];
        }
        var changed = false;
        this._data.forEach(function (p, i) {
          if (!p._id) { p._id = 'p_' + Date.now() + '_' + i; changed = true; }
        });
        if (changed) this.guardar();
      },

      guardar: function () {
        localStorage.setItem('rc-profesores', JSON.stringify(this._data));
      },

      listar: function () {
        return this._data;
      },

      renderizar: function () {
        var container = document.getElementById('global-profesores-list');
        if (!container) return;
        container.innerHTML = '';
        var self = this;
        if (this._data.length === 0) {
          container.innerHTML = '<p style="color:#6b7280;font-size:13px;grid-column:1/-1;">No hay profesores registrados. Agrega uno usando el botón de arriba.</p>';
          return;
        }
        this._data.forEach(function (prof, idx) {
          var card = document.createElement('div');
          card.className = 'prof-card';
          card.innerHTML =
            '<div class="prof-card-img-wrap">' +
              '<img src="' + Admin.escAttr(prof.img || './img/profesor/default.jpg') + '" alt="' + Admin.escAttr(prof.gradoNombre) + '">' +
            '</div>' +
            '<div class="prof-card-info">' +
              '<h4>' + Admin.escAttr(prof.gradoNombre) + '</h4>' +
            '</div>' +
            '<div class="prof-card-actions">' +
              '<button class="btn-edit" onclick="Admin.profesoresGlobal.mostrarFormulario(' + idx + ')">✎ Editar</button>' +
              '<button class="btn-delete-sm" onclick="Admin.profesoresGlobal.eliminar(' + idx + ')">✕ Eliminar</button>' +
            '</div>';
          container.appendChild(card);
        });
      },

      mostrarFormulario: function (idx) {
        this._editIdx = idx >= 0 ? idx : -1;
        var data = idx >= 0 ? this._data[idx] : {gradoNombre:'', primerNombre:'', img:'', secciones:[]};
        document.getElementById('prof-global-gradoNombre').value = data.gradoNombre || '';
        document.getElementById('prof-global-primerNombre').value = data.primerNombre || '';
        document.getElementById('prof-global-img').value = data.img || '';
        var preview = document.getElementById('prof-img-preview');
        preview.src = data.img || './img/profesor/default.jpg';
        if (preview.dataset.objectUrl) {
          URL.revokeObjectURL(preview.dataset.objectUrl);
          delete preview.dataset.objectUrl;
        }
        delete preview.dataset.hasFile;
        var container = document.getElementById('prof-secciones-container');
        container.innerHTML = '';
        var secciones = data.secciones || [];
        if (!secciones.length && (data.formacionLI || data.experienciaLI || data.docenciaLI)) {
          if (data.formacionLI) secciones.push({ titulo: 'Formación Profesional', elementos: this._parseLIs(data.formacionLI) });
          if (data.experienciaLI) secciones.push({ titulo: 'Experiencia Profesional', elementos: this._parseLIs(data.experienciaLI) });
          if (data.docenciaLI) secciones.push({ titulo: 'Experiencia de docente - autor de libros', elementos: this._parseLIs(data.docenciaLI) });
        }
        var self = this;
        secciones.forEach(function (sec) { self._renderSeccion(sec); });
        var fileInput = document.getElementById('prof-img-file');
        fileInput.value = '';
        fileInput.onchange = function () { self.handleFileInput(this, preview); };
        document.getElementById('modalProfesorGlobalTitle').textContent = idx >= 0 ? 'Editar Profesor' : 'Agregar Profesor';
        var modal = new bootstrap.Modal(document.getElementById('modalProfesorGlobal'));
        modal.show();
      },

      guardarFormulario: async function () {
        var data = {
          gradoNombre: document.getElementById('prof-global-gradoNombre').value.trim(),
          primerNombre: document.getElementById('prof-global-primerNombre').value.trim(),
          img: '',
          secciones: []
        };
        if (!data.gradoNombre || !data.primerNombre) {
          Admin.showToast('Completa al menos el nombre completo y primer nombre', 'error');
          return;
        }
        var fileInput = document.getElementById('prof-img-file');
        if (fileInput.files[0]) {
          var formData = new FormData();
          formData.append('file', fileInput.files[0]);
          formData.append('gradoNombre', data.gradoNombre);
          try {
            var resp = await fetch('upload.php', { method: 'POST', body: formData });
            var result = await resp.json();
            if (result.url) {
              data.img = result.url;
            } else {
              Admin.showToast('Error al subir imagen: ' + (result.error || 'desconocido'), 'error');
              return;
            }
          } catch (e) {
            var httpStatus = resp ? resp.status : 'sin respuesta';
            Admin.showToast('Error al subir imagen: ' + e.message + ' (HTTP ' + httpStatus + ')', 'error');
            Admin.showToast('Verifica que upload.php existe y la carpeta profesores/ tiene permisos de escritura.', 'error');
            return;
          }
        } else {
          data.img = document.getElementById('prof-global-img').value.trim() || '';
        }
        var container = document.getElementById('prof-secciones-container');
        container.querySelectorAll('.prof-seccion-card').forEach(function (card) {
          var titulo = card.querySelector('.prof-seccion-titulo').value.trim();
          var elementos = [];
          card.querySelectorAll('.prof-elemento-input').forEach(function (input) {
            var val = input.value.trim();
            if (val) elementos.push(val);
          });
          if (titulo) data.secciones.push({ titulo: titulo, elementos: elementos });
        });
        if (this._editIdx >= 0) {
          data._id = this._data[this._editIdx]._id;
          this._data[this._editIdx] = data;
        } else {
          data._id = 'p_' + Date.now() + '_' + Math.random().toString(36).slice(2, 6);
          this._data.push(data);
        }
        this.guardar();
        this.renderizar();
        // Sync with plantilla if the same professor is selected
        if (Admin.currentState && Admin.currentState.profesores) {
          var synced = false;
          Admin.currentState.profesores.forEach(function (pp, i) {
            if (pp._id && pp._id === data._id) {
              Admin.currentState.profesores[i] = JSON.parse(JSON.stringify(data));
              synced = true;
            }
          });
          if (synced) Admin.profesoresPlantilla.renderizar();
        }
        bootstrap.Modal.getInstance(document.getElementById('modalProfesorGlobal')).hide();
        Admin.showToast('Profesor ' + (this._editIdx >= 0 ? 'actualizado' : 'agregado') + ' correctamente', 'success');
      },

      addSeccion: function () {
        var container = document.getElementById('prof-secciones-container');
        var tpl = document.getElementById('prof-seccion-template');
        if (!container || !tpl) return;
        var clone = tpl.content.cloneNode(true);
        container.appendChild(clone);
      },

      removeSeccion: function (btn) {
        var card = btn.closest('.prof-seccion-card');
        if (card && confirm('¿Eliminar esta sección?')) {
          card.remove();
        }
      },

      addElemento: function (btn) {
        var card = btn.closest('.prof-seccion-card');
        if (!card) return;
        var container = card.querySelector('.prof-seccion-elementos');
        var tpl = document.getElementById('prof-elemento-template');
        if (!container || !tpl) return;
        var clone = tpl.content.cloneNode(true);
        container.appendChild(clone);
      },

      removeElemento: function (btn) {
        var row = btn.closest('.prof-elemento-row');
        if (row) row.remove();
      },

      handleFileInput: function (input, previewEl) {
        var file = input.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
          Admin.showToast('El archivo debe ser una imagen', 'error');
          input.value = '';
          return;
        }
        if (file.size > 2 * 1024 * 1024) {
          Admin.showToast('La imagen no debe superar los 2MB', 'error');
          input.value = '';
          return;
        }
        if (previewEl.dataset.objectUrl) {
          URL.revokeObjectURL(previewEl.dataset.objectUrl);
        }
        var url = URL.createObjectURL(file);
        previewEl.src = url;
        previewEl.dataset.objectUrl = url;
        previewEl.dataset.hasFile = '1';
      },

      _renderSeccion: function (sec) {
        var container = document.getElementById('prof-secciones-container');
        var tpl = document.getElementById('prof-seccion-template');
        if (!container || !tpl) return;
        var clone = tpl.content.cloneNode(true);
        var card = clone.querySelector('.prof-seccion-card');
        card.querySelector('.prof-seccion-titulo').value = sec.titulo || '';
        var elemContainer = card.querySelector('.prof-seccion-elementos');
        var self = this;
        (sec.elementos || []).forEach(function (elem) {
          var etpl = document.getElementById('prof-elemento-template');
          if (!etpl) return;
          var eclone = etpl.content.cloneNode(true);
          eclone.querySelector('.prof-elemento-input').value = elem;
          elemContainer.appendChild(eclone);
        });
        container.appendChild(clone);
      },

      _parseLIs: function (htmlStr) {
        var elementos = [];
        var regex = /<li>(.*?)<\/li>/g;
        var match;
        while ((match = regex.exec(htmlStr)) !== null) {
          elementos.push(match[1]);
        }
        return elementos;
      },

      eliminar: function (idx) {
        if (!confirm('¿Eliminar este profesor?')) return;
        this._data.splice(idx, 1);
        this.guardar();
        this.renderizar();
        Admin.showToast('Profesor eliminado', 'success');
      }
    },

    profesoresPlantilla: {
      renderizar: function () {
        var container = document.getElementById('plantilla-profesores-list');
        if (!container) return;
        container.innerHTML = '';
        var profesores = Admin.currentState.profesores || [];
        if (profesores.length === 0) {
          container.innerHTML = '<p style="color:#6b7280;font-size:13px;grid-column:1/-1;">No hay profesores seleccionados para esta plantilla.</p>';
          return;
        }
        profesores.forEach(function (prof, idx) {
          var card = document.createElement('div');
          card.className = 'prof-card';
          card.innerHTML =
            '<div class="prof-card-img-wrap">' +
              '<img src="' + Admin.escAttr(prof.img || './img/profesor/default.jpg') + '" alt="' + Admin.escAttr(prof.gradoNombre) + '">' +
            '</div>' +
            '<div class="prof-card-info">' +
              '<h4>' + Admin.escAttr(prof.gradoNombre) + '</h4>' +
            '</div>' +
            '<div class="prof-card-actions">' +
              '<button class="btn-delete-sm" onclick="Admin.profesoresPlantilla.quitar(' + idx + ')">✕ Quitar</button>' +
            '</div>';
          container.appendChild(card);
        });
      },

      abrirSelector: function () {
        var globales = Admin.profesoresGlobal.listar();
        if (globales.length === 0) {
          Admin.showToast('No hay profesores en el gestor global. Agrega profesores primero.', 'error');
          return;
        }
        var existing = Admin.currentState.profesores || [];
        var body = document.getElementById('selectorProfesoresBody');
        body.innerHTML = '';
        globales.forEach(function (prof, idx) {
          var alreadyIn = existing.some(function (p) { return p.primerNombre === prof.primerNombre && p.gradoNombre === prof.gradoNombre; });
          var label = document.createElement('label');
          label.className = 'selector-prof-item';
          label.innerHTML =
            '<input type="checkbox" class="selector-prof-check" value="' + idx + '" ' + (alreadyIn ? 'checked' : '') + '>' +
            '<span>' + Admin.escAttr(prof.gradoNombre) + '</span>';
          body.appendChild(label);
        });
        var modal = new bootstrap.Modal(document.getElementById('modalSeleccionarProfesores'));
        modal.show();
      },

      confirmarSeleccion: function () {
        var checks = document.querySelectorAll('#selectorProfesoresBody .selector-prof-check:checked');
        var selected = [];
        checks.forEach(function (chk) {
          var idx = parseInt(chk.value);
          var prof = Admin.profesoresGlobal.listar()[idx];
          if (prof) selected.push(JSON.parse(JSON.stringify(prof)));
        });
        Admin.currentState.profesores = selected;
        this.renderizar();
        bootstrap.Modal.getInstance(document.getElementById('modalSeleccionarProfesores')).hide();
        Admin.showToast('Profesores actualizados en la plantilla', 'success');
      },

      quitar: function (idx) {
        var profesores = Admin.currentState.profesores || [];
        profesores.splice(idx, 1);
        Admin.currentState.profesores = profesores;
        this.renderizar();
      }
    },

    escAttr: function (str) {
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    }
  };

  window.Admin = Admin;
})();

document.addEventListener('DOMContentLoaded', function () {
  Admin.init();
});
