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
      this.calcAhorro();
      this.updatePreviewLink();

      document.addEventListener('input', function () {
        self.syncStateFromForm();
        self.calcAhorro();
        self.updatePreviewLink();
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
    },

    syncStateFromForm: function () {
      var self = this;
      document.querySelectorAll('[data-field]').forEach(function (el) {
        var field = el.dataset.field;
        self.currentState[field] = el.value;
      });
      this.syncDynamicList('objetivos', ['titulo', 'descripcion']);
      this.syncDynamicList('participantes', ['titulo', 'descripcion']);
      this.syncDynamicList('profesores', ['gradoNombre', 'primerNombre', 'img', 'formacionLI', 'experienciaLI', 'docenciaLI']);
      this.syncTemarioHierarchy();
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
      this.renderList('profesores', this.currentState.profesores || []);
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
        this.calcAhorro();
        this.updatePreviewLink();
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
      this.calcAhorro();
      this.updatePreviewLink();
      this.showToast('Plantilla "' + name + '" eliminada', 'success');
    },

    updatePreviewLink: function () {
      this.syncStateFromForm();
      this.calcAhorro();
      var name = document.getElementById('templateNameInput')?.value.trim();
      var link = document.getElementById('previewLink');
      if (!link) return;
      if (name) {
        link.href = './index.html?template=' + encodeURIComponent(name);
      } else {
        link.href = './index.html';
      }
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
