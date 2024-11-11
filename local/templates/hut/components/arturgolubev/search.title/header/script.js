function JCTitleSearchAG(arParams) {
  var _this = this;

  if (!arParams.POPUP_HISTORY) {
    arParams.POPUP_HISTORY = "N";
  }

  this.arParams = {
    AJAX_PAGE: arParams.AJAX_PAGE,
    CONTAINER_ID: arParams.CONTAINER_ID,
    WRAP_ID: arParams.WRAP_ID,
    INNER_ID: arParams.INNER_ID,
    INPUT_ID: arParams.INPUT_ID,
    POPUP_HISTORY: arParams.POPUP_HISTORY,
    POPUP_HISTORY_TITLE: arParams.POPUP_HISTORY_TITLE,
    PAGE: arParams.PAGE,
    MIN_QUERY_LEN: parseInt(arParams.MIN_QUERY_LEN),
  };
  if (arParams.WAIT_IMAGE) this.arParams.WAIT_IMAGE = arParams.WAIT_IMAGE;

  this.elements = {
    clear: null,
    preloader: null,
  };

  if (arParams.PRELODER_ID) {
    this.elements.preloader = BX(arParams.PRELODER_ID);
  }
  if (arParams.CLEAR_ID) {
    this.elements.clear = BX(arParams.CLEAR_ID);
  }
  if (arParams.VOICE_ID) {
    this.elements.voice = BX(arParams.VOICE_ID);
  }

  if (arParams.MIN_QUERY_LEN <= 0) arParams.MIN_QUERY_LEN = 1;

  this.cache = [];
  this.cache_key = null;

  this.startText = "";
  this.running = false;

  this.currentRow = -1;
  this.RESULT = null;
  this.CONTAINER = null;
  this.INPUT = null;
  this.WAIT = null;
  this.toggler = document.getElementById("search_opener");
  this.inputSearch = document.getElementById("smart-title-search-input");
  this.overlay = document.querySelector(".search-title__overlay");
  this.submit = document.querySelector(".search-title__submit");
  this.historyWrap = document.querySelector(
    ".search-title__popular-wrap--history"
  );
  this.srartBlock = document.querySelector(".search-title__start");
  this.closeButton = document.querySelector(".search-title__close");

  this.ShowResult = function (result) {
    if (BX.type.isString(result)) {
      _this.RESULT.innerHTML = result;
    }

    _this.RESULT.style.display =
      _this.RESULT.innerHTML !== "" ? "block" : "none";

    _this.srartBlock.style.display =
      _this.RESULT.style.display === "block" ? "none" : "block";
    // var pos = _this.adjustResultNode();

    // //adjust left column to be an outline
    // var res_pos;
    // var th;
    // var tbl = BX.findChild(
    //   _this.RESULT,
    //   { tag: "table", class: "title-search-result" },
    //   true
    // );
    // if (tbl) {
    //   th = BX.findChild(tbl, { tag: "th" }, true);
    // }

    // if (th) {
    //   var tbl_pos = BX.pos(tbl);
    //   tbl_pos.width = tbl_pos.right - tbl_pos.left;

    //   var th_pos = BX.pos(th);
    //   th_pos.width = th_pos.right - th_pos.left;
    //   th.style.width = th_pos.width + "px";

    //   _this.RESULT.style.width = pos.width + th_pos.width + "px";

    //   //Move table to left by width of the first column
    //   _this.RESULT.style.left = pos.left - th_pos.width - 1 + "px";

    //   //Shrink table when it's too wide
    //   if (tbl_pos.width - th_pos.width > pos.width)
    //     _this.RESULT.style.width = pos.width + th_pos.width - 1 + "px";

    //   //Check if table is too wide and shrink result div to it's width
    //   tbl_pos = BX.pos(tbl);
    //   res_pos = BX.pos(_this.RESULT);
    //   if (res_pos.right > tbl_pos.right) {
    //     _this.RESULT.style.width = tbl_pos.right - tbl_pos.left + "px";
    //   }
    // }

    // var fade;
    // if (tbl)
    //   fade = BX.findChild(_this.RESULT, { class: "title-search-fader" }, true);
    // if (fade && th) {
    //   res_pos = BX.pos(_this.RESULT);
    //   fade.style.left = res_pos.right - res_pos.left - 18 + "px";
    //   fade.style.width = 18 + "px";
    //   fade.style.top = 0 + "px";
    //   fade.style.height = res_pos.bottom - res_pos.top + "px";
    //   fade.style.display = "block";
    // }
  };

  this.onKeyPress = function (keyCode) {
    var tbl = BX.findChild(
      _this.RESULT,
      { tag: "table", class: "title-search-result" },
      true
    );
    if (!tbl) return false;

    var i;
    var cnt = tbl.rows.length;

    switch (keyCode) {
      case 27: // escape key - close search div
        _this.RESULT.style.display = "none";
        _this.currentRow = -1;
        _this.UnSelectAll();
        return true;

      case 40: // down key - navigate down on search results
        if (_this.RESULT.style.display == "none")
          _this.RESULT.style.display = "block";

        var first = -1;
        for (i = 0; i < cnt; i++) {
          if (
            !BX.findChild(
              tbl.rows[i],
              { class: "title-search-separator" },
              true
            )
          ) {
            if (first == -1) first = i;

            if (_this.currentRow < i) {
              _this.currentRow = i;
              break;
            } else if (tbl.rows[i].className == "title-search-selected") {
              tbl.rows[i].className = "";
            }
          }
        }

        if (i == cnt && _this.currentRow != i) _this.currentRow = first;

        tbl.rows[_this.currentRow].className = "title-search-selected";
        return true;

      case 38: // up key - navigate up on search results
        if (_this.RESULT.style.display == "none")
          _this.RESULT.style.display = "block";

        var last = -1;
        for (i = cnt - 1; i >= 0; i--) {
          if (
            !BX.findChild(
              tbl.rows[i],
              { class: "title-search-separator" },
              true
            )
          ) {
            if (last == -1) last = i;

            if (_this.currentRow > i) {
              _this.currentRow = i;
              break;
            } else if (tbl.rows[i].className == "title-search-selected") {
              tbl.rows[i].className = "";
            }
          }
        }

        if (i < 0 && _this.currentRow != i) _this.currentRow = last;

        tbl.rows[_this.currentRow].className = "title-search-selected";
        return true;

      case 13: // enter key - choose current search result
        if (_this.RESULT.style.display == "block") {
          for (i = 0; i < cnt; i++) {
            if (_this.currentRow == i) {
              if (
                !BX.findChild(
                  tbl.rows[i],
                  { class: "title-search-separator" },
                  true
                )
              ) {
                var a = BX.findChild(tbl.rows[i], { tag: "a" }, true);
                if (a) {
                  window.location = a.href;
                  return true;
                }
              }
            }
          }
        }
        return false;
    }

    return false;
  };

  this.onTimeout = function () {
    _this.onChange(function () {
      setTimeout(_this.onTimeout, 500);
    });
  };

  this.onChange = function (callback) {
    if (_this.running) return;

    _this.checkButtonsVisible();

    _this.running = true;

    if (
      _this.INPUT.value != _this.oldValue &&
      _this.INPUT.value != _this.startText
    ) {
      _this.oldValue = _this.INPUT.value;
      if (_this.INPUT.value.length >= _this.arParams.MIN_QUERY_LEN) {
        _this.cache_key = _this.arParams.INPUT_ID + "|" + _this.INPUT.value;
        if (_this.cache[_this.cache_key] == null) {
          if (_this.WAIT) {
            var pos = BX.pos(_this.INPUT);
            var height = pos.bottom - pos.top - 2;
            _this.WAIT.style.top = pos.top + 1 + "px";
            _this.WAIT.style.height = height + "px";
            _this.WAIT.style.width = height + "px";
            _this.WAIT.style.left = pos.right - height + 2 + "px";
            _this.WAIT.style.display = "block";
          }

          if (_this.elements.preloader) {
            BX.show(_this.elements.preloader);
          }

          BX.ajax.post(
            _this.arParams.AJAX_PAGE,
            {
              ajax_call: "y",
              INPUT_ID: _this.arParams.INPUT_ID,
              q: _this.INPUT.value,
              l: _this.arParams.MIN_QUERY_LEN,
            },
            function (result) {
              _this.cache[_this.cache_key] = result;
              _this.ShowResult(result);
              _this.currentRow = -1;
              _this.EnableMouseEvents();
              if (_this.WAIT) _this.WAIT.style.display = "none";

              if (_this.elements.preloader) {
                BX.hide(_this.elements.preloader);
              }

              if (!!callback) callback();
              _this.running = false;

              if (_this.INPUT.value != _this.oldValue) {
                _this.onChange();
              }
            }
          );
          return;
        } else {
          _this.ShowResult(_this.cache[_this.cache_key]);
          _this.currentRow = -1;
          _this.EnableMouseEvents();
        }
      } else {
        _this.RESULT.style.display = "none";
        _this.currentRow = -1;
        _this.UnSelectAll();
      }
    }
    if (!!callback) callback();
    _this.running = false;
  };

  this.UnSelectAll = function () {
    var tbl = BX.findChild(
      _this.RESULT,
      { tag: "table", class: "title-search-result" },
      true
    );
    if (tbl) {
      var cnt = tbl.rows.length;
      for (var i = 0; i < cnt; i++) tbl.rows[i].className = "";
    }
  };

  this.EnableMouseEvents = function () {
    var tbl = BX.findChild(
      _this.RESULT,
      { tag: "table", class: "title-search-result" },
      true
    );
    if (tbl) {
      var cnt = tbl.rows.length;
      for (var i = 0; i < cnt; i++)
        if (
          !BX.findChild(tbl.rows[i], { class: "title-search-separator" }, true)
        ) {
          tbl.rows[i].id = "row_" + i;
          tbl.rows[i].onmouseover = function (e) {
            if (_this.currentRow != this.id.substr(4)) {
              _this.UnSelectAll();
              this.className = "title-search-selected";
              _this.currentRow = this.id.substr(4);
            }
          };
          tbl.rows[i].onmouseout = function (e) {
            this.className = "";
            _this.currentRow = -1;
          };
        }
    }
  };

  this.onFocusLost = function (hide) {
    setTimeout(function () {
      _this.RESULT.style.display = "none";
    }, 250);
  };

  this.onFocusGain = function () {
    if (
      _this.RESULT.innerHTML.length &&
      _this.INPUT.value.length >= _this.arParams.MIN_QUERY_LEN
    )
      _this.ShowResult();
    else if (_this.arParams.POPUP_HISTORY == "Y") {
      _this.ShowResult(_this.getHistoryHtml());
    }
  };

  this.onKeyDown = function (e) {
    if (this.value === " " && this.value.length === 0) {
      this.value = "";
    }

    if (!e) e = window.event;

    if (_this.RESULT.style.display == "block") {
      if (_this.onKeyPress(e.keyCode)) return BX.PreventDefault(e);
    }
  };

  this.adjustResultNode = function () {
    if (
      !(
        BX.type.isElementNode(_this.RESULT) &&
        BX.type.isElementNode(_this.CONTAINER)
      )
    ) {
      return { top: 0, right: 0, bottom: 0, left: 0, width: 0, height: 0 };
    }

    var pos = BX.pos(_this.CONTAINER);

    _this.RESULT.style.position = "absolute";
    _this.RESULT.style.top = pos.bottom + 2 + "px";
    _this.RESULT.style.left = pos.left + "px";
    _this.RESULT.style.width = pos.width + "px";

    return pos;
  };

  // voice input
  this.initVoiceInput = function () {
    if (_this.elements.voice) {
      window.SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;
      if (window.SpeechRecognition) {
        _this.elements.voice.classList.add("voice-show");

        _this.voiceRecorderActive = 0;

        _this.voiceRecorder = new SpeechRecognition();
        _this.voiceRecorder.interimResults = true;
        _this.voiceRecorder.lang = "ru-RU";

        _this.voiceRecorder.addEventListener("start", function () {
          _this.voiceRecorderActive = 1;
          _this.elements.voice.classList.add("active");
        });

        _this.voiceRecorder.addEventListener("end", function () {
          _this.voiceRecorderActive = 0;
          _this.elements.voice.classList.remove("active");
        });

        _this.voiceRecorder.addEventListener("result", function (e) {
          _this.INPUT.value = e.results[0][0].transcript;
          if (e.results[0].isFinal) {
            _this.onChange();
          }
        });

        _this.voiceRecorder.addEventListener("error", function (e) {
          _this.voiceRecorderActive = 0;
          _this.elements.voice.classList.remove("active");

          // e.error == 'no-speech'
        });

        _this.elements.voice.addEventListener("click", function () {
          if (!_this.voiceRecorderActive) {
            _this.voiceRecorder.start();
          } else {
            _this.voiceRecorder.stop();
          }
        });
      }
    }
  };

  this.searchHistory = function () {
    document.body.addEventListener("click", function (evt) {
      if (evt.target.classList.contains("history")) {
        evt.preventDefault();
        _this.INPUT.value = evt.target.textContent;
        _this.onChange();
      }
    });
  };

  // clear
  this.initClear = function () {
    if (this.elements.clear) {
      this.elements.clear.addEventListener("click", function () {
        _this.RESULT.style.display = "none";
        _this.srartBlock.style.display = "block";
        _this.INPUT.value = "";
        _this.onChange();
      });
    }
  };
  this.checkButtonsVisible = function () {
    if (_this.elements.clear) {
      if (_this.INPUT.value) {
        _this.elements.clear.style.display = "block";
      } else {
        _this.elements.clear.style.display = "none";
      }
    }

    if (_this.elements.voice && window.SpeechRecognition) {
      if (_this.INPUT.value) {
        _this.elements.voice.style.display = "none";
      } else {
        _this.elements.voice.style.display = "block";
      }
    }
  };

  // history
  this.getCookie = function (name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
  };

  this.getHistoryHtml = function () {
    var html = "",
      history = _this.getCookie("BITRIX_SM_AG_SMSE_H");

    if (history) {
      history = decodeURI(history).replace("+", " ");

      var arHistory = history.split("|");
      if (arHistory.length) {
        html =
          html +
          '<div class="bx_smart_searche bx_searche"><div class="bx-searchtitle-popup-history">';
        html =
          html +
          '<div class="bx-searchtitle-popup-history-title">' +
          _this.arParams.POPUP_HISTORY_TITLE +
          "</div>";
        arHistory.reverse().forEach(function (item) {
          html =
            html +
            '<div class="bx-searchtitle-popup-history-item"><a class="js_search_href" href="' +
            _this.arParams.PAGE +
            "?q=" +
            item +
            '">' +
            item +
            "</a></div>";
        });
        html = html + "</div></div>";
      }
    }

    return html;
  };

  this.showSearch = function (evt) {
    evt.preventDefault();
    document.getElementById(this.arParams.WRAP_ID).style.display = "block";
    this.overlay.style.display = "block";
  };

  this.hideSearch = function (evt) {
    evt.preventDefault();
    document.getElementById(this.arParams.WRAP_ID).style.display = "none";
    this.overlay.style.display = "none";
  };

  this.addLocalStorage = function (evt) {
    evt.preventDefault();
    let value = document.getElementById(this.arParams.INPUT_ID).value;
    let currentStorage = localStorage.getItem("search_history");
    if (!currentStorage) {
      localStorage.setItem("search_history", value);
    } else if (!currentStorage.includes(value)) {
      localStorage.setItem("search_history", (currentStorage += ";" + value));
    }
    document.querySelector("#" + this.arParams.WRAP_ID + " form").submit();
  };

  this.renderSearchHistory = function () {
    let currentStorage = localStorage.getItem("search_history");
    if (!currentStorage) {
      return;
    }
    let domElement = document.createElement("UL");
    domElement.classList.add("search-title__popular");
    let html = "";
    const parts = currentStorage.split(";");
    const partsReversed = parts.reverse().slice(0, 5);
    partsReversed.forEach((element) => {
      html += '<li><a class="history" href="#">' + element + "</a></li>";
    });
    domElement.innerHTML = html;
    this.historyWrap.appendChild(domElement);
    this.historyWrap.style.display = "block";
  };

  this.clearLocalStorege = function () {
    let deleteButton = document.querySelector(".search-title__remove-history");
    deleteButton.addEventListener("click", function () {
      localStorage.removeItem("search_history");
      _this.historyWrap.style.display = "none";
    });
  };

  // init
  this.Init = function () {
    this.CONTAINER = document.getElementById(this.arParams.CONTAINER_ID);

    this.RESULT = document
      .getElementById(this.arParams.INNER_ID)
      .appendChild(document.createElement("DIV"));
    this.RESULT.className = "title-search-result";

    this.INPUT = document.getElementById(this.arParams.INPUT_ID);
    // BX.bind(this.INPUT, "focus", function () {
    //   _this.onFocusGain();
    // });
    // BX.bind(this.INPUT, "blur", function (e) {
    //   if (!!e.relatedTarget) {
    //     if (!BX.hasClass(BX(e.relatedTarget), "js_search_href")) {
    //       _this.onFocusLost();
    //     }
    //   } else {
    //     _this.onFocusLost();
    //   }
    // });

    this.INPUT.oninput = () => {
      if(this.INPUT.value.charAt(0) === ' ') {
        this.INPUT.value = '';
      }
    }
    this.INPUT.onkeydown = this.onKeyDown;

    this.startText = this.oldValue = this.INPUT.value;

    if (this.arParams.WAIT_IMAGE) {
      this.WAIT = document.body.appendChild(document.createElement("DIV"));
      this.WAIT.style.backgroundImage =
        "url('" + this.arParams.WAIT_IMAGE + "')";
      if (!BX.browser.IsIE()) this.WAIT.style.backgroundRepeat = "none";
      this.WAIT.style.display = "none";
      this.WAIT.style.position = "absolute";
      this.WAIT.style.zIndex = "1100";
    }

    BX.bind(this.INPUT, "bxchange", function () {
      _this.onChange();
    });
    BX.bind(this.INPUT, "paste", function (e) {
      setTimeout(function () {
        _this.onChange();
      }, 200);
    });

    BX.bind(this.toggler, "click", function (e) {
      _this.showSearch(e);
    });

    BX.bind(this.overlay, "click", function (e) {
      _this.hideSearch(e);
    });

    BX.bind(this.submit, "click", function (e) {
      _this.addLocalStorage(e);
    });

    BX.bind(this.closeButton, "click", function (e) {
      _this.hideSearch(e);
    });

    this.initClear();
    this.initVoiceInput();
    this.renderSearchHistory();
    this.clearLocalStorege();
    this.searchHistory();
  };
  BX.ready(function () {
    _this.Init(arParams);
  });
}
