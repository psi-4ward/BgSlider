/**
 * BgSlider
 *
 * A mootools based fullscreen background slider with fade effect for Contao 3.
 *
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 * @licence LGPL
 */

var BgSlider = new Class({

	Implements: [Options],

	options: {
		duration: 1500,
		delay: 1500,
		autoplay: true,
		showNav: true,
		slideAfterLoad: true,
		keepRatio: false,
		domID: '',
		cssClass: ''
	},

	imgEls: [],
	src: [],
	curr:0,
	cnt:0,
	preloaded:[],
	timer: false,


	initialize: function(images, options)
	{
		this.setOptions(options);
		this.src = images;

		var container = document.id(document.body);
		if(this.options.domID || this.options.cssClass)
		{
			container = new Element('div',{id:this.options.domID}).addClass(this.options.cssClass).inject(container,'top');
		}

		for(var i=0;i<2;i++)
		{
			this.imgEls[i] = new Element('img',{
				'styles': {
					'position': 'fixed',
					'max-width': 'none',
					'height': '100%',
					'width': '100%',
					'z-index': '-1'-i
				},
				'src': this.src[i].path
			}).inject(container, 'top');
			if(this.options.keepRatio)
			{
				this.setImageSize(this.imgEls[i], this.src[i]);
			}
		}


		this.fx = new Fx.Elements(this.imgEls,{duration: this.options.duration, link:'ignore'})
		this.preload[0] = true;

		if(this.options.slideAfterLoad)
		{
			if(Cookie.read('BgSlider.lastImg'))
			{
				this.imgEls[0].set('src',Cookie.read('BgSlider.lastImg'));
				this.imgEls[1].set('src',this.src[0].path);
				this.curr = -1;
				this.startFX();
			}
			else
			{
				Cookie.write('BgSlider.lastImg',this.src[0].path);
			}
		}


		if(this.options.showNav)
		{
			new  Element('span',{
				'id':'BgSliderNext',
				'events':{
					'click': this.next.bind(this)
				}
			}).inject(container,'bottom');
			new  Element('span',{
				'id':'BgSliderPrev',
				'events':{
					'click': this.prev.bind(this)
				}
			}).inject(container,'bottom');
		}

		if(this.options.autoplay) this.play();

		if(this.options.keepRatio)
		{
			window.addEvent('resize', function()
			{
				this.setImageSize(this.imgEls[0], this.src[this.curr]);
				this.setImageSize(this.imgEls[1], this.src[this.curr]);
			}.bind(this));
		}

	},


	play: function()
	{
		this.timer = 0;
		this.startFX();
	},


	stop: function()
	{
		clearTimeout(this.timer);
		this.timer = false;
	},


	next: function()
	{
		if(this.timer !== false) clearTimeout(this.timer);
		if(this.curr >= this.src.length) this.curr=0;
		this.startFX();
	},


	prev: function()
	{
		if(this.timer !== false) clearTimeout(this.timer);
		this.curr -= 2;
		if(this.curr < -1) this.curr=this.src.length-2;
		this.startFX();
	},


	preload: function(i)
	{
		this.preloaded[i]=false;
		Asset.image(this.src[i].path,{'onLoad':function(){this.preloaded[i]=true;}.bind(this)});
	},


	startFX: function()
	{
		var top = this.cnt%2;
		var bottom = (this.cnt+1)%2;

		var next = this.curr+1;
		if(next >= this.src.length) next=0;


		if(typeof this.preloaded[next] == 'undefined')
			this.preload(next);
		else if(typeof this.preloaded[next] === false)
		{
			this.startFX.delay(150,this);
			return;
		}
		else
		{
			this.preload(next);
		}

		this.imgEls[bottom].set('src',this.src[next].path);
		if(this.options.keepRatio)
		{
			this.setImageSize(this.imgEls[bottom], this.src[next]);
		}

		var transMatrix = {};
		transMatrix[top] = {opacity:0};
		transMatrix[bottom] = {opacity:1};

		this.fx.start(transMatrix).chain(function()
		{
			Cookie.write('BgSlider.lastImg',this.src[next].path);
			this.cnt++;
			this.curr++;
			if(this.curr >= this.src.length) this.curr=0;
			if(this.timer !== false) this.timer = this.startFX.delay(this.options.delay,this);
		}.bind(this));
	},


	setImageSize: function(el, elSize)
	{
		var winSize = window.getSize();

		var ratios = {
			x: winSize.x / elSize.width,
			y: winSize.y / elSize.height
		};

		el.setStyles({
			'width': elSize.width * ((ratios.x < ratios.y) ? ratios.y : ratios.x),
			'height': elSize.height * ((ratios.x < ratios.y) ? ratios.y : ratios.x)
		});
	}



});