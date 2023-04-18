class i {
  constructor(i3) {
    this.slider = void 0, this.canvas = void 0, this.canvasContext = void 0, this.canvasWidth = 0, this.canvasHeight = 0, this.fit = true, this.img = void 0, this.imgHeight = void 0, this.imgWidth = void 0, this.scale = void 0, this.baseScale = 1, this.maxScale = 5, this.minScale = 1, this.originalWidth = void 0, this.originalHeight = void 0, this.ratio = void 0, this.isDown = void 0, this.pointerX = void 0, this.pointerY = void 0, this.netPanningX = void 0, this.netPanningY = void 0, this.originX = void 0, this.originY = void 0, this.eventCache = void 0, this.prevDiff = void 0, this.onResize = this.debounce(() => {
      if (!this.img)
        return;
      const i4 = this.canvas.offsetWidth - this.canvasWidth, t2 = this.canvas.offsetHeight - this.canvasHeight;
      this.canvasWidth = this.canvas.width = this.canvas.offsetWidth, this.canvasHeight = this.canvas.height = this.canvas.offsetHeight, this.fit && this.imgWidth < this.canvasWidth ? (this.netPanningX = 0, this.onImageLoad()) : this.fit && this.imgHeight < this.canvasHeight ? (this.netPanningY = 0, this.onImageLoad()) : (this.netPanningX += i4 / 2, this.netPanningY += t2 / 2, this.originalWidth = this.canvasWidth, this.originalHeight = this.canvasWidth * this.ratio, this.draw()), this.fixScale();
    }, 300), this.baseScale = (i3 == null ? void 0 : i3.baseScale) || this.baseScale, this.maxScale = (i3 == null ? void 0 : i3.maxScale) || this.maxScale, this.minScale = (i3 == null ? void 0 : i3.minScale) || this.minScale, this.loadCanvas((i3 == null ? void 0 : i3.canvas) || document.createElement("canvas"), i3 == null ? void 0 : i3.width, i3 == null ? void 0 : i3.height), (i3 == null ? void 0 : i3.rangeInput) && this.loadSlider(i3.rangeInput), i3 != null && i3.imageUrl && this.loadImageFromUrl(i3 == null ? void 0 : i3.imageUrl, i3 == null ? void 0 : i3.fit, () => {
      this.move((i3 == null ? void 0 : i3.x) || 0, (i3 == null ? void 0 : i3.y) || 0), i3 == null || i3.onImageLoad == null || i3.onImageLoad();
    });
  }
  clamp(i3, t2, h2) {
    return Math.max(t2, Math.min(i3, h2));
  }
  debounce(i3, t2) {
    let h2;
    return (...s2) => {
      clearTimeout(h2), h2 = setTimeout(() => {
        i3(...s2);
      }, t2);
    };
  }
  initPointerAndZoom() {
    this.isDown = false, this.netPanningX = 0, this.netPanningY = 0, this.eventCache = [], this.prevDiff = -1, this.slider && (this.slider.value = String(this.baseScale));
  }
  draw() {
    var i3, t2;
    this.img && ((i3 = this.canvasContext) == null || i3.clearRect(0, 0, this.canvasWidth, this.canvasHeight), (t2 = this.canvasContext) == null || t2.drawImage(this.img, this.netPanningX, this.netPanningY, this.imgWidth, this.imgHeight));
  }
  fixScale() {
    this.scale = this.fit ? Math.min(this.imgWidth / this.canvasWidth, this.imgHeight / this.canvasHeight) || this.baseScale : Math.min(this.imgWidth / this.originalWidth, this.imgHeight / this.originalHeight) || this.baseScale, this.slider && (this.slider.value = String(this.scale));
  }
  onImageLoad() {
    this.fit && (this.scale = Math.max(this.canvasHeight / this.imgHeight, this.canvasWidth / this.imgWidth), this.imgHeight *= this.scale, this.imgWidth *= this.scale), this.pointerX = this.pointerY = 0, this.originalWidth = this.imgWidth, this.originalHeight = this.imgHeight, this.ratio = this.originalHeight / this.originalWidth, this.draw();
  }
  getPointerAverage() {
    let i3 = 0, t2 = 0;
    for (let h2 = 0; h2 < this.eventCache.length; h2++)
      i3 += this.eventCache[h2].offsetX, t2 += this.eventCache[h2].offsetY;
    return i3 /= this.eventCache.length, t2 /= this.eventCache.length, [i3, t2];
  }
  calcOrigin(i3, t2) {
    this.originX = (-this.netPanningX + i3) / this.imgWidth, this.originY = (-this.netPanningY + t2) / this.imgHeight;
  }
  move(i3, t2) {
    const h2 = i3 - this.pointerX, s2 = t2 - this.pointerY;
    this.pointerX = i3, this.pointerY = t2, this.netPanningX = this.fit ? this.clamp(this.netPanningX + h2, this.canvasWidth - this.imgWidth, 0) : this.netPanningX + h2, this.netPanningY = this.fit ? this.clamp(this.netPanningY + s2, this.canvasHeight - this.imgHeight, 0) : this.netPanningY + s2;
  }
  drawZoom(i3, t2) {
    this.netPanningX = this.fit ? this.clamp(this.netPanningX - i3 * this.originX, this.canvasWidth - this.imgWidth, 0) : this.netPanningX - i3 * this.originX, this.netPanningY = this.fit ? this.clamp(this.netPanningY - t2 * this.originY, this.canvasHeight - this.imgHeight, 0) : this.netPanningY - t2 * this.originY;
  }
  zoomDelta(i3, t2) {
    const h2 = this.imgWidth + i3;
    h2 < this.originalWidth || this.imgHeight + t2 < this.originalHeight || h2 / this.originalWidth > this.maxScale || h2 / this.originalWidth < this.minScale || (this.slider && (this.slider.value = String(this.scale = h2 / this.originalWidth)), this.imgWidth = h2, this.imgHeight += t2, this.drawZoom(i3, t2));
  }
  zoomScale(i3) {
    if (i3 > this.maxScale || i3 < this.minScale)
      return;
    this.prevDiff = -1;
    let t2 = this.imgWidth, h2 = this.imgHeight;
    this.imgWidth = this.originalWidth * i3, this.imgHeight = this.originalHeight * i3, t2 -= this.imgWidth, h2 -= this.imgHeight, this.calcOrigin(this.canvasWidth / 2, this.canvasHeight / 2), this.drawZoom(-t2, -h2);
  }
  pinch() {
    if (this.eventCache.length === 2) {
      const i3 = Math.hypot(this.eventCache[0].offsetX - this.eventCache[1].offsetX, this.eventCache[0].offsetY - this.eventCache[1].offsetY);
      if (this.prevDiff > 0) {
        const t2 = i3 - this.prevDiff;
        this.zoomDelta(t2, t2 * this.ratio);
      }
      this.prevDiff = i3;
    }
  }
  onSliderMove(i3) {
    this.scale = +i3.target.value, this.zoomScale(this.scale), this.draw();
  }
  onPointerdown(i3) {
    this.img && (this.eventCache.push(i3), [this.pointerX, this.pointerY] = this.getPointerAverage(), this.isDown = true);
  }
  onPointerUp(i3) {
    this.isDown && (this.eventCache = this.eventCache.filter((t2) => t2.pointerId !== i3.pointerId), this.eventCache.length < 2 && (this.prevDiff = -1), [this.pointerX, this.pointerY] = this.getPointerAverage(), this.eventCache.length === 0 && (this.isDown = false));
  }
  onPointermove(i3) {
    if (!this.isDown)
      return;
    for (let t3 = 0; t3 < this.eventCache.length; t3++)
      if (i3.pointerId === this.eventCache[t3].pointerId) {
        this.eventCache[t3] = i3;
        break;
      }
    const [t2, h2] = this.getPointerAverage();
    this.move(t2, h2), this.pinch(), this.calcOrigin(this.canvasWidth / 2, this.canvasHeight / 2), this.draw();
  }
  prevent(i3) {
    i3.preventDefault(), i3.stopPropagation();
  }
  leadListeners() {
    this.canvas.addEventListener("pointerdown", (i3) => {
      this.prevent(i3), this.onPointerdown(i3);
    }), this.canvas.addEventListener("pointermove", (i3) => {
      this.prevent(i3), this.onPointermove(i3);
    }), this.canvas.addEventListener("pointerout", (i3) => {
      this.prevent(i3), this.onPointerUp(i3);
    }), this.canvas.addEventListener("pointerup", (i3) => {
      this.prevent(i3), this.onPointerUp(i3);
    }), this.canvas.addEventListener("pointercancel", (i3) => {
      this.prevent(i3), this.onPointerUp(i3);
    }), this.canvas.addEventListener("pointerleave", (i3) => {
      this.prevent(i3), this.onPointerUp(i3);
    }), new ResizeObserver(this.onResize).observe(this.canvas);
  }
  loadSlider(i3) {
    this.slider = i3, this.slider.value = String(this.scale || this.baseScale), this.slider.addEventListener("input", (i4) => {
      this.prevent(i4), this.onSliderMove(i4);
    });
  }
  loadCanvas(i3, t2, h2) {
    this.canvas = i3, this.canvasContext = this.canvas.getContext("2d"), this.canvasWidth = this.canvas.width = t2 || this.canvas.offsetWidth, this.canvasHeight = this.canvas.height = h2 || this.canvas.offsetHeight, this.leadListeners();
  }
  loadImageFromUrl(i3, t2 = true, h2) {
    if (!this.canvas)
      throw Error("first call loadCanvas");
    this.fit = t2, this.img = new Image(), this.img.onload = () => {
      this.initPointerAndZoom(), this.imgHeight = this.img.naturalHeight, this.imgWidth = this.img.naturalWidth, this.onImageLoad(), h2 == null || h2();
    }, this.img.src = i3;
  }
  getCanvas(i3) {
    if (!this.img)
      throw Error("please set an image");
    const t2 = document.createElement("canvas");
    return t2.width = this.canvasWidth * i3, t2.height = this.canvasHeight * i3, t2.getContext("2d").drawImage(this.img, this.netPanningX * i3, this.netPanningY * i3, this.imgWidth * i3, this.imgHeight * i3), t2;
  }
  getBlob(i3 = 1) {
    return new Promise((t2) => {
      this.getCanvas(i3).toBlob((i4) => {
        t2(i4);
      });
    });
  }
  getDataUrl(i3 = 1) {
    return this.getCanvas(i3).toDataURL();
  }
  download(i3 = 1) {
    const t2 = document.createElement("a");
    t2.download = "canvas.png", t2.href = this.getDataUrl(i3), t2.click();
  }
  getCropInfo() {
    return {originalWidth: this.img.naturalWidth, originalHeight: this.img.naturalHeight, imgWidth: this.imgWidth, imgHeight: this.imgHeight, x: this.netPanningX, y: this.netPanningY};
  }
}
const t = new i({});
function h(...i2) {
  t.download(...i2);
}
function s(...i2) {
  t.loadCanvas(...i2);
}
function e(...i2) {
  t.loadImageFromUrl(...i2);
}
function n(...i2) {
  t.loadSlider(...i2);
}
function a(...i2) {
  t.move(...i2);
}
function o(...i2) {
  t.getCropInfo(...i2);
}
function g(...i2) {
  t.getDataUrl(...i2);
}
export {i as Cropo, h as download, o as getCropInfo, g as getDataUrl, s as loadCanvas, e as loadImageFromUrl, n as loadSlider, a as move};
export default null;
