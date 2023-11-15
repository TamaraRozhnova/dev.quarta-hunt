window.addEventListener("DOMContentLoaded", () => {
  class Compare {
    constructor() {
      this.productCardElements = document.querySelectorAll(".product-card");
      this.productCountElement = document.querySelector(".compare__count");
      this.compareContainer = document.querySelector(".compare__container");
      this.compareTable = document.querySelector(".compare__table");
      this.compareItems = document.querySelectorAll(".compare__item");

      this.columnBackdrop = document.querySelector(".compare__column-backdrop");
      this.compareRows = document.querySelectorAll(".compare__row");
      this.compareCols = document.querySelectorAll(".compare__col");
      this.compareDividers = document.querySelectorAll(".compare__divider");

      this.moveLeftButton = document.querySelector(".move-left");
      this.moveRightButton = document.querySelector(".move-right");

      this.productsCount = this.productCardElements.length;
      this.onlyDifferent = false;
      this.scrollOffset = 0;
      this.offsetMemo = 0;
      this.containerSize = 1000;
      this.divider = 4;

      this.productsDataApi = new ProductsDataApi();
      this.compareApi = new CompareApi();
      this.setCompareQuantity();
      this.updateContainerSize();
      this.hangEvents();
    }

    hangEvents() {
      this.compareTable.addEventListener("scroll", () => this.onScroll());
      window.addEventListener("resize", () => this.updateContainerSize());
      this.hangDragEvents();
      this.hangOnlyDifferentCheckboxEvents();
      this.hangCleanButtonEvents();
      this.hangProductCardsEvents();
      this.hangMoveLeft();
      this.hangMoveRight();
    }

    setStyles() {
      this.columnBackdrop.style.width = `${
        this.containerSize / this.divider
      }px`;
      this.columnBackdrop.style.transform = `translateX(${this.scrollOffset}px)`;
      const width =
        (this.containerSize / this.divider) * (this.productsCount + 1);
      this.compareRows.forEach((row) => {
        row.style.width = `${Math.max(this.containerSize - 32, width)}px`;
      });
      this.compareDividers.forEach((row) => {
        row.style.width = `${Math.max(this.containerSize - 32, width)}px`;
      });
      this.compareCols.forEach((column) => {
        column.style.width = `${this.containerSize / this.divider}px`;
      });
    }

    onScroll() {
      if (this.dragActive) {
        return;
      }
      this.offsetMemo = this.compareTable.scrollLeft;
      this.scrollOffset = this.compareTable.scrollLeft;
      this.setStyles();
    }

    updateContainerSize() {
      const windowWidth = window.outerWidth;
      if (windowWidth >= 991 && windowWidth > 479) {
        this.divider = 4;
      } else if (windowWidth <= 575) {
        this.divider = 2;
      } else {
        this.divider = 3;
      }
      this.containerSize = this.compareContainer.getBoundingClientRect().width;
      this.setStyles();
    }

    setCompareQuantity() {
      if (!this.productCountElement) {
        return;
      }
      this.productCountElement.innerHTML = getPluralString(this.productsCount, [
        "товар",
        "товара",
        "товаров",
      ]);
    }

    hangDragEvents() {
      this.dragGesture = new DragGesture(
        this.compareTable,
        ({ active, movement: [mx], event }) =>
          this.handleDrag(active, mx, event),
        {
          axis: "x",
          eventOptions: {
            capture: true,
            passive: false,
          },
        }
      );
    }

    hangMoveLeft() {
      this.moveLeftButton.addEventListener("click", () => {
        this.handleMove(-this.getMoveValue("left"));
      });
    }

    hangMoveRight() {
      this.moveRightButton.addEventListener("click", () => {
        this.handleMove(this.getMoveValue("right"));
      });
    }

    handleMove(offset) {
      this.compareTable.scrollTo({
        left: this.offsetMemo - offset,
        top: 0,
        behavior: "smooth",
      });
      this.offsetMemo = this.compareTable.scrollLeft;
      this.scrollOffset = this.compareTable.scrollLeft;
      this.setStyles();
    }

    getMoveValue(direction) {
      let toScroll = this.compareItems[0].offsetWidth;
      let currentOffset = 0;

      if (this.compareTable.scrollLeft !== 0) {
        currentOffset =
          Math.round((this.compareTable.scrollLeft / toScroll) * 10) / 10;
      }

      if (!Number.isInteger(currentOffset)) {
        if (direction === "left") {
          toScroll = (Math.ceil(currentOffset) - currentOffset) * toScroll;
        } else {
          toScroll = (currentOffset - Math.floor(currentOffset)) * toScroll;
        }
      }

      return toScroll;
    }

    handleDrag(active, mx, event) {
      event.preventDefault();
      if (this.dragActive !== active) {
        this.dragActive = active;
      }
      this.compareTable.scrollLeft = this.offsetMemo - mx;
      this.scrollOffset = this.compareTable.scrollLeft;
      if (!this.dragActive) {
        this.offsetMemo = this.compareTable.scrollLeft;
      }
      this.setStyles();
    }

    hangOnlyDifferentCheckboxEvents() {
      const checkbox = document.querySelector("#only-different");
      if (!checkbox) {
        return;
      }
      checkbox.addEventListener("click", (event) =>
        this.handleChangeDifferentCheckbox(event.target.checked)
      );
    }

    handleChangeDifferentCheckbox(newValue) {
      const comparePropsToHide = document.querySelectorAll(
        '.compare__prop[data-different="false"]'
      );
      const value = newValue ?? this.onlyDifferent;
      if (value) {
        comparePropsToHide.forEach(
          (element) => (element.style.display = "none")
        );
      } else {
        comparePropsToHide.forEach(
          (element) => (element.style.display = "flex")
        );
      }
      this.onlyDifferent = value;
    }

    hangCleanButtonEvents() {
      const cleanButton = document.querySelector(".compare__clear");
      if (!cleanButton) {
        return;
      }
      cleanButton.addEventListener("click", () => {
        this.compareApi.clearCompare().then((response) => {
          if (response) {
            this.showEmptyBlock();
          }
        });
      });
    }

    handleDeleteCompare(productId) {
      this.productsCount--;
      this.setCompareQuantity();
      if (this.productsCount === 1) {
        this.showAddMoreBlock();
        return;
      }
      if (!this.productsCount) {
        this.showEmptyBlock();
      } else {
        this.deleteElements(productId);
        this.setStyles();
      }
    }

    showAddMoreBlock() {
      const compareTableWrapper = document.querySelector(
        ".compare__table-wrapper"
      );
      const addMoreElement = document.querySelector(".compare__add-more");
      compareTableWrapper.style.display = "none";
      addMoreElement.style.display = "block";
    }

    deleteElements(productId) {
      const productCardWrapper = document.querySelector(
        `.compare__item[data-id="${productId}"]`
      );
      const comparePropColumnElements = document.querySelectorAll(
        `.compare__prop .compare__col--main[data-id="${productId}"]`
      );
      const ratingElement = document.querySelector(
        `.compare__rating[data-id="${productId}"]`
      );
      comparePropColumnElements.forEach((element) => element.remove());
      productCardWrapper.remove();
      ratingElement.remove();
      this.changePropsRows();
    }

    changePropsRows() {
      const comparePropElements = document.querySelectorAll(".compare__prop");
      comparePropElements.forEach((element) => {
        let isStayProp = false;
        let isDifferentProp = false;
        let firstPropValue = "";
        const columnElements = element.querySelectorAll(".compare__col--main");
        columnElements.forEach((column) => {
          const value = column.dataset.value;
          if (!value) {
            return;
          }
          if (!firstPropValue) {
            firstPropValue = value;
          } else if (firstPropValue != value) {
            isDifferentProp = true;
          }
          isStayProp = true;
        });
        if (!isStayProp) {
          element.remove();
          return;
        }
        element.dataset.different = isDifferentProp;
        this.handleChangeDifferentCheckbox();
      });
    }

    showEmptyBlock() {
      const compareTableWrapper = document.querySelector(
        ".compare__table-wrapper"
      );
      const emptyElement = document.querySelector(".compare__empty");
      this.productCountElement.style.display = "none";
      compareTableWrapper.style.display = "none";
      emptyElement.style.display = "block";
    }

    hangProductCardsEvents() {
      const productIds = Array.from(this.productCardElements).map(
        (element) => element.dataset.id
      );
      if (!productIds.length) {
        return;
      }
      this.productsDataApi.getData(productIds).then((response) => {
        new ProductCards(response, {
          onDeleteCompare: (productId) => this.handleDeleteCompare(productId),
        });
        const ratingElements = document.querySelectorAll(".compare__rating");
        ratingElements.forEach((element) => {
          new RatingStarsHelper({
            productElement: element,
            ratingsList: response.RATINGS,
          });
        });
      });
    }
  }

  new Compare();
});
