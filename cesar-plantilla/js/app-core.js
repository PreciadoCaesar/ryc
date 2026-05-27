(function () {
  'use strict';

  var STORAGE_PREFIX = 'rc-template-';
  var LAST_TEMPLATE_KEY = 'rc-last-template';

  var defaultState = {
    tituloCursoLargo: 'Curso SIAF WEB 2026: Práctica en Administrativo, Presupuesto, Contable y Tesorería',
    tituloCursoCorto: 'Curso SIAF WEB 2026',
    tipoPrograma: 'Curso',
    modalidad: 'Online',
    slugUrl: 'curso-siaf-web-2026-practica-administrativo-presupuesto-contable-tesoreria',
    descripcionSEO: 'Capacitación 100% práctica en el Sistema Integrado de Administración Financiera SIAF-SP WEB versión 25.02.00.',
    keywords: 'SIAF WEB, gestión pública, presupuesto público, SIAF-SP, MEF, capacitación',
    fechaInicio: '23 de Junio',
    fechaInicioISO: '2026-06-23',
    fechaLimiteOferta: '15 de junio',
    precioOferta: '197.00',
    precioProntoPago: '237.00',
    precioRegular: '257.00',
    numeroSesiones: '6',
    horasCertificacion: '90',
    tipoCertificado: 'Curso Especializado',
    urlBrochurePDF: '#',
    temarioTitulo: 'SIAF RP Y WEB 2026 + INTELIGENCIA ARTIFICIAL',
    imgPortadaVideo: './img/curso-siaf-web-2026-junio.jpeg',
    urlVideoVimeo: 'https://player.vimeo.com/video/',
    ogImageURL: 'https://rc-consulting.org/img/curso/curso-siaf-web-2026-junio.jpeg',
    imgInhouseDesktop: './img/inhouse-01.webp',
    imgInhouseMobile: './img/inhouse-02.webp',
    descripcionInhouse: 'Solicita una propuesta personalizada para tu institución alineada al PDP 2026.',
    asesoraNombre: 'Romina',
    asesoraTelefono: '51999551532',
    asesoraFoto: './img/4x/3. Romina Sirlopu.webp',
    asesorInhouseNombre: 'Arnaldo',
    asesorInhouseTelefono: '51948163352',
    hojaDestinoSheets: 'CURSO: SIAF WEB - JUNIO',
    nombreCursoSheets: 'Curso Online SIAF WEB 2026',
    urlCarritoPago: '#',
    profesoresDC: 'Dr. Marlon Prieto Hormaza, Mag. Evelyn Meres Morales',
    objetivos: [
      { titulo: 'Excelencia en la Formación de Funcionarios:', descripcion: 'Brindar una capacitación de alto nivel que fortalezca las competencias técnicas del personal del sector público.' },
      { titulo: 'Fortalecimiento de Capacidades Institucionales:', descripcion: 'Dotar a los participantes de herramientas prácticas para optimizar la gestión pública.' }
    ],
    participantes: [
      { titulo: 'Servidores Públicos y Planeamiento:', descripcion: 'Profesionales vinculados a la programación presupuestaria y planeamiento institucional.' }
    ],
    temarioTipo: 'jerarquico',
    sesiones: [
      { numero: 1, titulo: 'SESIÓN 1: MARCO NORMATIVO ACTUALIZADO AL 2026', contenido: [
        { tipo: 'lista', texto: 'Marco normativo del SIAF-SP WEB' },
        { tipo: 'lista', texto: 'Directiva 00214-2025-SERVIR-PE' }
      ] }
    ],
    cursos: [
      {
        titulo: 'CURSO 1: PRESUPUESTO PÚBLICO 2026',
        lecturasPrevias: '<p><strong>Lecturas Previas Obligatorias:</strong></p><ul><li>Ley Nº 32069</li><li>DS Nº 009-2025-EF</li></ul>',
        modulos: [],
        sesiones: [
          { titulo: 'SESIÓN 1: Análisis Estratégico', contenido: [{ tipo: 'lista', texto: 'Tema 1' }, { tipo: 'lista', texto: 'Tema 2' }] },
          { titulo: 'SESIÓN 2: Los 4 Cambios', contenido: [{ tipo: 'lista', texto: 'Tema A' }, { tipo: 'lista', texto: 'Tema B' }] }
        ]
      }
    ],
    modulos: [],
    profesores: [
      {
        gradoNombre: 'DR. MARLON PRIETO HORMAZA',
        primerNombre: 'Marlon',
        img: './img/profesor/profesor-01.jpg',
        formacionLI: '<li>Doctor en Contabilidad</li><li>Master en Gerencia Pública</li>',
        experienciaLI: '<li>Especialista en DGCP del MEF</li><li>Consultor en gestión pública</li>',
        docenciaLI: '<li>Autor de Manual Práctico del SIAF</li>'
      }
    ]
  };

  function getWAPrograma(s) {
    return s.tipoPrograma + ' ' + s.modalidad + ' \'' + s.tituloCursoLargo + '\'';
  }

  var waPatterns = [
    { selector: '.wa-banner-inhouse', phoneKey: 'asesorInhouseTelefono', textFn: function (s) { return 'Hola ' + s.asesorInhouseNombre + ', vengo de la web. Me interesa solicitar una Propuesta In House del ' + getWAPrograma(s) + ' para mi institución alineada al PDP 2026. ¿Podrías ayudarme?'; } },
    { selector: '.wa-asesora-pago', phoneKey: 'asesoraTelefono', textFn: function (s) { return 'Hola ' + s.asesoraNombre + ', podrías guiarme para realizar el pago del ' + getWAPrograma(s) + '.'; } },
    { selector: '.wa-asesora-consulta', phoneKey: 'asesoraTelefono', textFn: function (s) { return 'Hola ' + s.asesoraNombre + ', consulta sobre el ' + getWAPrograma(s) + '. Información y Promoción, por favor.'; } },
    { selector: '.wa-asesora-reservar', phoneKey: 'asesoraTelefono', textFn: function (s) { return 'Hola ' + s.asesoraNombre + ', deseo reservar mi vacante para el ' + getWAPrograma(s) + '. Podrías ayudarme, por favor.'; } },
    { selector: '.wa-gracias', phoneKey: 'asesoraTelefono', textFn: function (s) { return 'Hola ' + s.asesoraNombre + ', acabo de registrar mis datos en el ' + getWAPrograma(s) + '. Quedo a la espera de tu contacto.'; } },
    { selector: '.wa-flotante', phoneKey: 'asesoraTelefono', textFn: function (s) { return 'Hola ' + s.asesoraNombre + ', consulta sobre el ' + getWAPrograma(s) + '. Información y Promoción, por favor.'; } }
  ];

  function generateWAUrl(phone, text) {
    return 'https://wa.me/' + phone + '?text=' + encodeURIComponent(text);
  }

  function deepClone(obj) {
    return JSON.parse(JSON.stringify(obj));
  }

  var RCEngine = {
    state: {},

    init: function (templateName) {
      var loaded = null;
      if (templateName) {
        loaded = this.loadTemplate(templateName);
      } else {
        loaded = this.loadLastTemplate();
      }
      this.state = loaded ? deepClone(loaded) : deepClone(defaultState);
      this.render();
    },

    getDefaultState: function () {
      return deepClone(defaultState);
    },

    render: function () {
      var s = this.state;

      // Auto-calculate ahorro
      var reg = parseFloat(s.precioRegular) || 0;
      var ofe = parseFloat(s.precioOferta) || 0;
      s.ahorro = String(Math.max(0, Math.round(reg - ofe)));

      // data-bind elements
      document.querySelectorAll('[data-bind]').forEach(function (el) {
        var key = el.dataset.bind;
        var value = s[key];
        if (value === undefined || value === null) return;

        if (el.tagName === 'IMG' || el.tagName === 'SOURCE') {
          if (key.indexOf('img') === 0 || key.indexOf('foto') !== -1 || key.indexOf('Foto') !== -1 || key.indexOf('Portada') !== -1 || key.indexOf('Inhouse') !== -1 || key.indexOf('OG') !== -1) {
            el.src = value;
          }
        } else if (el.tagName === 'META') {
          el.content = value;
        } else if (el.tagName === 'TITLE') {
          el.textContent = value + ' | R&C Consulting';
        } else if (el.tagName === 'A' && el.classList.contains('btn-brochure')) {
          el.href = value;
        } else {
          el.textContent = value;
        }
      });

      // Render dynamic lists
      this.renderObjetivos();
      this.renderParticipantes();
      if (s.temarioTipo === 'jerarquico') {
        this.renderTemarioJerarquico();
      } else {
        this.renderSesiones();
      }
      this.renderProfesores();

      // Render WhatsApp links
      this.renderWALinks();

      // Update JSON-LD
      this.renderJSONLD();

      // Update carrito pago URL
      var carritoBtns = document.querySelectorAll('.btn-pago-tarjeta, .btn-acceder-card, .btn-acceder-card-no-margin');
      carritoBtns.forEach(function (el) {
        el.onclick = function (e) {
          e.preventDefault();
          var w = 500, h = 650;
          var left = (screen.width - w) / 2;
          var top = (screen.height - h) / 2;
          window.open(s.urlCarritoPago, 'PagoNiubiz', 'width=' + w + ',height=' + h + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes');
        };
      });

      // Hide/show panel amarillo on mobile
      this.renderMobileUI();
    },

    renderObjetivos: function () {
      var container = document.querySelector('.objetivos-wrap');
      if (!container) return;
      var tpl = document.getElementById('tpl-objetivo');
      if (!tpl) return;
      container.innerHTML = '';
      var items = this.state.objetivos || [];
      items.forEach(function (item, i) {
        var clone = tpl.content.cloneNode(true);
        var tituloEl = clone.querySelector('.obj-titulo');
        var descEl = clone.querySelector('.obj-descripcion');
        if (tituloEl) tituloEl.textContent = '● ' + item.titulo;
        if (descEl) descEl.textContent = item.descripcion;
        if (i === items.length - 1) {
          var wrapper = clone.querySelector('.valor-item');
          if (wrapper) wrapper.style.borderBottom = 'none';
        }
        container.appendChild(clone);
      });
    },

    renderParticipantes: function () {
      var container = document.querySelector('.participantes-wrap');
      if (!container) return;
      var tpl = document.getElementById('tpl-participante');
      if (!tpl) return;
      container.innerHTML = '';
      var items = this.state.participantes || [];
      items.forEach(function (item, i) {
        var clone = tpl.content.cloneNode(true);
        var tituloEl = clone.querySelector('.part-titulo');
        var descEl = clone.querySelector('.part-descripcion');
        if (tituloEl) tituloEl.textContent = '● ' + item.titulo;
        if (descEl) descEl.textContent = item.descripcion;
        if (i === items.length - 1) {
          var wrapper = clone.querySelector('.valor-item');
          if (wrapper) wrapper.style.borderBottom = 'none';
        }
        container.appendChild(clone);
      });
    },

    _elemHTML: function (item) {
      if (!item.elementos || !item.elementos.length) return '';
      var h = '<ul>';
      for (var j = 0; j < item.elementos.length; j++) {
        h += '<li>' + item.elementos[j] + '</li>';
      }
      return h + '</ul>';
    },

    renderContenidoHTML: function (items) {
      if (typeof items === 'string') return items;
      if (!Array.isArray(items)) return '';
      var html = '';
      var listOpen = false;
      if (items.length > 0) html += '<br>';
      for (var i = 0; i < items.length; i++) {
        var item = items[i];
        // backward compat: old sublista becomes lista
        if (item.tipo === 'sublista') item.tipo = 'lista';
        var text = item.texto || '';
        switch (item.tipo) {
          case 'subtitulo':
            if (listOpen) { html += '</ul>'; listOpen = false; }
            html += '<p><strong>' + text + '</strong></p>';
            break;
          case 'texto':
            if (listOpen) { html += '</ul>'; listOpen = false; }
            html += '<p style="margin-bottom:.5rem"><strong>' + text + '</strong></p>';
            break;
          case 'lista':
            if (!listOpen) { html += '<ul>'; listOpen = true; }
            if (item.elementos && item.elementos.length) {
              html += '<li><strong>' + text + '</strong>' + this._elemHTML(item) + '</li>';
            } else {
              html += '<li>' + text + this._elemHTML(item) + '</li>';
            }
            break;
        }
      }
      if (listOpen) html += '</ul>';
      return html;
    },

    renderSesiones: function () {
      var container = document.querySelector('#sesAcc');
      if (!container) return;
      var tpl = document.getElementById('tpl-sesion');
      if (!tpl) return;
      container.innerHTML = '';
      var items = this.state.sesiones || [];
      var self = this;
      items.forEach(function (item) {
        var clone = tpl.content.cloneNode(true);
        var btn = clone.querySelector('.accordion-button');
        var collapse = clone.querySelector('.accordion-collapse');
        var body = clone.querySelector('.accordion-body');
        if (btn) {
          btn.textContent = item.titulo;
          btn.setAttribute('data-bs-target', '#s' + item.numero);
        }
        if (collapse) collapse.id = 's' + item.numero;
        if (body) body.innerHTML = self.renderContenidoHTML(item.contenido);
        container.appendChild(clone);
      });
    },

    renderTemarioJerarquico: function () {
      var container = document.querySelector('#sesAcc');
      if (!container) return;
      var tplCurso = document.getElementById('tpl-curso');
      var tplModulo = document.getElementById('tpl-modulo');
      var tplSesion = document.getElementById('tpl-sesion');
      if (!tplCurso || !tplModulo || !tplSesion) return;

      container.innerHTML = '';
      var cursos = this.state.cursos || [];
      var self = this;

      cursos.forEach(function (curso, ci) {
        var cClone = tplCurso.content.cloneNode(true);
        var cBtn = cClone.querySelector('.btn-curso');
        var cSpan = cClone.querySelector('.btn-curso > span');
        var cCollapse = cClone.querySelector('.curso-collapse');
        var cModulos = cClone.querySelector('.curso-modulos');
        var cSesDirectas = cClone.querySelector('.curso-sesiones-directas');
        var cLecturas = cClone.querySelector('.curso-lecturas');

        if (cSpan) {
          cSpan.textContent = curso.titulo;
        } else if (cBtn) {
          cBtn.textContent = curso.titulo;
        }
        if (cBtn) {
          cBtn.setAttribute('data-bs-target', '#c' + ci);
        }
        if (cCollapse) cCollapse.id = 'c' + ci;
        if (cLecturas && curso.lecturasPrevias) {
          cLecturas.innerHTML = curso.lecturasPrevias;
        } else if (cLecturas) {
          cLecturas.style.display = 'none';
        }

        var modulos = curso.modulos || [];

        if (modulos.length > 0) {
          // Render módulos
          modulos.forEach(function (modulo, mi) {
            var mClone = tplModulo.content.cloneNode(true);
            var mBtn = mClone.querySelector('.btn-modulo');
            var mSpan = mClone.querySelector('.btn-modulo > span');
            var mCollapse = mClone.querySelector('.modulo-collapse');
            var mSesiones = mClone.querySelector('.modulo-sesiones');

            if (mSpan) {
              mSpan.textContent = modulo.titulo;
            } else if (mBtn) {
              mBtn.textContent = modulo.titulo;
            }
            if (mBtn) {
              mBtn.setAttribute('data-bs-target', '#c' + ci + 'm' + mi);
            }
            if (mCollapse) mCollapse.id = 'c' + ci + 'm' + mi;

            var sesiones = modulo.sesiones || [];
            sesiones.forEach(function (sesion, si) {
              var sClone = tplSesion.content.cloneNode(true);
              var sBtn = sClone.querySelector('.accordion-button');
              var sCollapse = sClone.querySelector('.accordion-collapse');
              var sBody = sClone.querySelector('.accordion-body');

              if (sBtn) {
                sBtn.textContent = sesion.titulo;
                sBtn.setAttribute('data-bs-target', '#c' + ci + 'm' + mi + 's' + si);
              }
              if (sCollapse) sCollapse.id = 'c' + ci + 'm' + mi + 's' + si;
              if (sBody) sBody.innerHTML = self.renderContenidoHTML(sesion.contenido);

              if (mSesiones) mSesiones.appendChild(sClone);
            });

            if (cModulos) cModulos.appendChild(mClone);
          });
          if (cSesDirectas) cSesDirectas.style.display = 'none';
        } else {
          // No modules → render sesiones directas en el curso
          if (cModulos) cModulos.style.display = 'none';
          var sesDirectas = curso.sesiones || [];
          sesDirectas.forEach(function (sesion, si) {
            var sClone = tplSesion.content.cloneNode(true);
            var sBtn = sClone.querySelector('.accordion-button');
            var sCollapse = sClone.querySelector('.accordion-collapse');
            var sBody = sClone.querySelector('.accordion-body');

            if (sBtn) {
              sBtn.textContent = sesion.titulo;
              sBtn.setAttribute('data-bs-target', '#c' + ci + 's' + si);
            }
            if (sCollapse) sCollapse.id = 'c' + ci + 's' + si;
            if (sBody) sBody.innerHTML = self.renderContenidoHTML(sesion.contenido);

            if (cSesDirectas) cSesDirectas.appendChild(sClone);
          });
        }

        container.appendChild(cClone);
      });

      // Render módulos independientes (sin curso padre)
      var standaloneModulos = this.state.modulos || [];
      standaloneModulos.forEach(function (modulo, smi) {
        var mClone = tplModulo.content.cloneNode(true);
        var mBtn = mClone.querySelector('.btn-modulo');
        var mSpan = mClone.querySelector('.btn-modulo > span');
        var mCollapse = mClone.querySelector('.modulo-collapse');
        var mSesiones = mClone.querySelector('.modulo-sesiones');

        if (mSpan) {
          mSpan.textContent = modulo.titulo;
        } else if (mBtn) {
          mBtn.textContent = modulo.titulo;
        }
        if (mBtn) {
          mBtn.setAttribute('data-bs-target', '#sm' + smi);
        }
        if (mCollapse) mCollapse.id = 'sm' + smi;

        var sesiones = modulo.sesiones || [];
        sesiones.forEach(function (sesion, ssi) {
          var sClone = tplSesion.content.cloneNode(true);
          var sBtn = sClone.querySelector('.accordion-button');
          var sCollapse = sClone.querySelector('.accordion-collapse');
          var sBody = sClone.querySelector('.accordion-body');

          if (sBtn) {
            sBtn.textContent = sesion.titulo;
            sBtn.setAttribute('data-bs-target', '#sm' + smi + 's' + ssi);
          }
          if (sCollapse) sCollapse.id = 'sm' + smi + 's' + ssi;
          if (sBody) sBody.innerHTML = self.renderContenidoHTML(sesion.contenido);

          if (mSesiones) mSesiones.appendChild(sClone);
        });

        container.appendChild(mClone);
      });

      // Render sesiones independientes (sin curso ni módulo)
      var standaloneSesiones = this.state.sesiones || [];
      standaloneSesiones.forEach(function (sesion, ssi) {
        var sClone = tplSesion.content.cloneNode(true);
        var sBtn = sClone.querySelector('.accordion-button');
        var sCollapse = sClone.querySelector('.accordion-collapse');
        var sBody = sClone.querySelector('.accordion-body');

        if (sBtn) {
          sBtn.textContent = sesion.titulo;
          sBtn.setAttribute('data-bs-target', '#ss' + ssi);
        }
        if (sCollapse) sCollapse.id = 'ss' + ssi;
        if (sBody) sBody.innerHTML = self.renderContenidoHTML(sesion.contenido);

        container.appendChild(sClone);
      });
    },

    renderProfesores: function () {
      var container = document.querySelector('.prof-scroll');
      if (!container) return;
      var tpl = document.getElementById('tpl-profesor');
      if (!tpl) return;

      // Remove old cards (keep only the template items)
      var existing = container.querySelectorAll('.col-prof');
      existing.forEach(function (el) { el.remove(); });

      var items = this.state.profesores || [];
      items.forEach(function (item) {
        var clone = tpl.content.cloneNode(true);
        var img = clone.querySelector('.prof-card__img');
        var name = clone.querySelector('.prof-card__name');
        var btn = clone.querySelector('.btn-ver-perfil');
        if (img) img.src = item.img;
        if (img) img.alt = item.gradoNombre;
        if (name) name.textContent = item.gradoNombre;
        if (btn) btn.setAttribute('data-bs-target', '#modal' + item.primerNombre);
        container.appendChild(clone);
      });

      // Render modals
      this.renderProfesorModals(items);
    },

    renderProfesorModals: function (items) {
      var container = document.querySelector('.profesor-modals-container');
      if (!container) return;
      var tpl = document.getElementById('tpl-modal-profesor');
      if (!tpl) return;
      container.innerHTML = '';
      items.forEach(function (item) {
        var clone = tpl.content.cloneNode(true);
        var modal = clone.querySelector('.modal');
        if (modal) modal.id = 'modal' + item.primerNombre;
        var title = clone.querySelector('.modal-title');
        if (title) title.textContent = item.gradoNombre;
        var formacion = clone.querySelector('.prof-formacion');
        if (formacion) formacion.innerHTML = item.formacionLI || '';
        var experiencia = clone.querySelector('.prof-experiencia');
        if (experiencia) experiencia.innerHTML = item.experienciaLI || '';
        var docencia = clone.querySelector('.prof-docencia');
        if (docencia) docencia.innerHTML = item.docenciaLI || '';
        container.appendChild(clone);
      });
    },

    renderWALinks: function () {
      var self = this;
      waPatterns.forEach(function (pattern) {
        var els = document.querySelectorAll(pattern.selector);
        if (!els.length) return;
        var phone = self.state[pattern.phoneKey] || '';
        var text = pattern.textFn(self.state);
        els.forEach(function (el) {
          el.href = generateWAUrl(phone, text);
        });
      });
    },

    renderJSONLD: function () {
      var s = this.state;
      var scripts = document.querySelectorAll('script[type="application/ld+json"]');
      scripts.forEach(function (script) {
        try {
          var json = JSON.parse(script.textContent);
          var update = function (obj) {
            if (typeof obj === 'string') {
              return obj
                .replace(/\{\{FECHA_INICIO_ISO\}\}/g, s.fechaInicioISO)
                .replace(/\{\{FECHA_INICIO\}\}/g, s.fechaInicio)
                .replace(/\{\{FECHA_LIMITE_OFERTA\}\}/g, s.fechaLimiteOferta)
                .replace(/\{\{PRECIO_OFERTA\}\}/g, s.precioOferta)
                .replace(/\{\{PRECIO_PRONTO_PAGO\}\}/g, s.precioProntoPago)
                .replace(/\{\{PRECIO_REGULAR\}\}/g, s.precioRegular)
                .replace(/\{\{TITULO_CURSO_LARGO\}\}/g, s.tituloCursoLargo);
            }
            if (obj && typeof obj === 'object') {
              Object.keys(obj).forEach(function (k) {
                obj[k] = update(obj[k]);
              });
            }
            return obj;
          };
          script.textContent = JSON.stringify(update(json));
        } catch (e) { /* ignore */ }
      });
    },

    renderMobileUI: function () {
      var s = this.state;
      var priceEls = document.querySelectorAll('.msb-price, .inv-price-main, .panel-price-main .panel-price-main > span');
      document.querySelectorAll('.msb-price').forEach(function (el) {
        el.innerHTML = '<span>S/.</span> ' + s.precioOferta;
      });
      document.querySelectorAll('.inv-price-main').forEach(function (el) {
        el.innerHTML = '<span>S/.</span> ' + s.precioOferta;
      });
    },

    updateState: function (newState) {
      this.state = deepClone(newState);
      this.render();
    },

    // --- Template CRUD ---

    saveTemplate: function (name, state) {
      localStorage.setItem(STORAGE_PREFIX + name, JSON.stringify(state));
      localStorage.setItem(LAST_TEMPLATE_KEY, name);
    },

    loadTemplate: function (name) {
      try {
        var raw = localStorage.getItem(STORAGE_PREFIX + name);
        return raw ? JSON.parse(raw) : null;
      } catch (e) { return null; }
    },

    deleteTemplate: function (name) {
      localStorage.removeItem(STORAGE_PREFIX + name);
      var last = localStorage.getItem(LAST_TEMPLATE_KEY);
      if (last === name) {
        var keys = this.listTemplates();
        localStorage.setItem(LAST_TEMPLATE_KEY, keys.length > 0 ? keys[0] : '');
      }
    },

    listTemplates: function () {
      var names = [];
      for (var i = 0; i < localStorage.length; i++) {
        var key = localStorage.key(i);
        if (key.indexOf(STORAGE_PREFIX) === 0) {
          names.push(key.substring(STORAGE_PREFIX.length));
        }
      }
      return names;
    },

    loadLastTemplate: function () {
      var name = localStorage.getItem(LAST_TEMPLATE_KEY);
      if (name) return this.loadTemplate(name);
      return null;
    },

    getWAPrograma: getWAPrograma,
    waPatterns: waPatterns,
    generateWAUrl: generateWAUrl,
    defaultState: defaultState
  };

  window.RCEngine = RCEngine;
})();
