import { Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { PropertyService } from '../property.service';
import { isPlatformServer, Location } from '@angular/common';
import { LeadService } from '../../lead/lead.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { EmailService } from '../email.service';
import { GoogleAnalyticsService } from '../../google-analytics.service';
import { environment } from '../../../environments/environment';
import * as $$ from '../../../assets/js/vendor/jquery-3.4.1.js';
import { Meta, Title } from '@angular/platform-browser';
import { LinkService } from '../../components/links/LinkService';

declare var $: any;

@Component({
  selector: 'app-property-detail',
  templateUrl: './property-detail.component.html',
  styleUrls: ['./property-detail.component.scss'],
  providers: [LinkService],
})
export class PropertyDetailComponent implements OnInit {
  showPhone: boolean;
  emailForm: FormGroup;
  visible = false;

  // custom code
  property: any = [];
  similarProperties: any = [];
  photos: any = [];
  id = '';
  shortId = '';
  dataRetrieved: any;
  device: any;
  checkPhoneNo: any;
  showMap: any;
  swiperHide = false;
  delay: any;
  similarPropertiesFetch: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private propertyService: PropertyService,
    private leadService: LeadService,
    public location: Location,
    private fb: FormBuilder,
    private email: EmailService,
    private googleAnalyticsService: GoogleAnalyticsService,
    private router: Router,
    private title: Title,
    private meta: Meta,
    private linkService: LinkService,
    @Inject(PLATFORM_ID) private platformId
  ) { }

  ngOnInit() {
    this.dataRetrieved = false;
    this.device = false;
    // this.id = this.route.snapshot.paramMap.get('id');
    this.route.params.subscribe(params => {
      const slug = this.route.snapshot.paramMap.get('slug');
      this.shortId = slug.split('-').pop();
      this.fetchPropertyByShortId();
      if (!isPlatformServer(this.platformId)) {
        // If not the server
        window.scroll(0, 0);
      }
    });
    this.showPhone = false;
    this.emailForm = this.fb.group({
      fromName: ['', Validators.required],
      fromEmail: ['', [Validators.required, Validators.email]],
      fromMobile: '',
      message: ['', Validators.required]
    });
    // custom code
    this.checkDeviceType();
    this.setTimer();
  }

  setTimer() {
    if (!isPlatformServer(this.platformId)) {
      setTimeout(() => {
        $('.swiper-wrapper-skeleton-new').addClass('swiperHide');
        $('.swiper-wrapper-load').removeClass('swiperHide');
      }, 1500);
    }
  }

  checkDeviceType() {
    let check = false;
    if (isPlatformServer(this.platformId)) {
      // If not the server
      return;
    }
    (function (a) {
      if (
        /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
          a
        ) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
          a.substr(0, 4)
        )
      )
        check = true;
    })(navigator.userAgent || navigator.vendor);
    this.device = check;
  }

  ngAfterViewChecked() {
    if (isPlatformServer(this.platformId)) {
      // If not the server
      return;
    }
    if ($$('.trending-card__logo_test').is(':visible')) {
      $$('.trending-card__logo_test').removeClass('trending-card__logo_test');
      this.setDetailsScript();
      this.similarPropertiesFetch = false;
    }
  }

  formatNumber(value) {
    if (value) {
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
  }

  revealPhone(): void {
    // Record a lead and reveal the phone number on the listing page
    this.showPhone = true;
    this.leadService.recordLead(this.property, 'PHONE').subscribe();
    this.googleAnalyticsService.eventEmitter('lead', 'phone');
  }

  sendWhatsApp(): void {
    // Record WhatsApp lead and send user to whatsapp URL
    this.leadService.recordLead(this.property, 'WHATSAPP').subscribe();
    this.googleAnalyticsService.eventEmitter('lead', 'whatsapp');
    this.checkPhoneNo = this.property.agent.phone.split(' ').join('');

    if (this.checkPhoneNo.slice(0, 1) === '+') {
      this.checkPhoneNo = this.checkPhoneNo.slice(1);
    }

    const text = `I've seen the property ${this.property.title} with reference ${this.property.reference} on houhaa. Please send me \
more information`;

    const whatsAppUrl = `https://api.whatsapp.com/send?phone=${this.checkPhoneNo}&text=${text}`;
    if (!isPlatformServer(this.platformId)) {
      // If not the server
      window.open(whatsAppUrl, '_blank');
    }
  }

  isMobileNumber(): boolean {
    // const regex = /^(?:\+971|971|00971|05|0)(?:2|3|4|6|7|9|50|51|52|55|56)[0-9]{7}$/;
    const number = this.property.agent && this.property.agent.phone && this.property.agent.phone.split(' ').join('');
    if (
      number &&
      number.slice(0, 2) !== '05' &&
      number.slice(0, 6) !== '009715' &&
      number.slice(0, 5) !== '+9715' &&
      number.slice(0, 4) !== '9715'
    ) {
      return false;
    } else {
      return true;
    }
  }

  sendMail(): void {
    this.email.sendEmail(this.property._id, this.emailForm.value).subscribe((result) => {
      if (result) {
        alert('Message sent succesfully');
        this.emailForm.reset();
        this.leadService.recordLead(this.property, 'EMAIL').subscribe();
        this.googleAnalyticsService.eventEmitter('lead', 'email');
        $.magnificPopup.close();
      }
    });
  }

  fetchPropertyByShortId() {
    console.log('calling fetch by short');
    this.propertyService.getPropertyByShortId(this.shortId).subscribe(
      (res) => {
        this.property = res;
        // Check URL is correct..
        const url = res.url;
        if (url !== this.router.url) {
          this.router.navigateByUrl(url);
        }
        this.id = this.property._id;
        this.title.setTitle(this.property.title.trim() + ' | houhaa');
        this.meta.updateTag({
          name: 'description', content: res.description.trim().substr(0, 110) + '...'
        }, `name='description'`);
        this.meta.updateTag({
            name: 'robots', content: 'index,follow'},
          `name='robots'`);
        this.linkService.removeTag('rel=canonical');
        this.linkService.addTag({
          rel: 'canonical', href: 'https://houhaa.com' + this.router.url
        });
        this.linkService.removeTag('rel=alternate');
        this.linkService.addTag({
          rel: 'alternate', hreflang: 'en', href: 'https://houhaa.com' + this.router.url
        });
        this.fetchSimilarProperties();
      },
      (err) => {
        console.log(err);
      }
    );
  }

  // get properties
  fetchSimilarProperties() {
    this.propertyService.getSimilarProperties(this.id).subscribe(
      (result) => {
        if (result.count === 3) {
          this.similarProperties = result.properties;
        } else {
          // If not 3 then don't show any
          this.similarProperties = [];
        }
        this.similarPropertiesFetch = true
      }
    ), (err) => {
      console.log(err);
    };
  }

  getLocationUrl(slug, listingType) {
    // Create URL linking to all listings in the chosen location for the
    // current listing type
    let url = '/en/';
    switch (listingType) {
      case 'RENT':
        url += 'rent/properties-for-rent-';
        break;
      case 'SALE':
        url += 'buy/properties-for-sale-';
        break;
      case 'COMMERCIAL_RENT':
        url += 'commercial-rent/properties-for-rent-';
        break;
      case 'COMMERCIAL_SALE':
        url += 'commercial-sale/properties-for-sale-';
        break;
      default:
        return '';
    }
    return url + slug;
  }

  getPropertyHeader(property) {
    if (property && property.agency && property.agency.logo && property.agency.logo.small) {
      return environment.S3_URL + property.agency.logo.small;
    }
  }

  getBackgroundColor(property) {
    if (property && property.agency && property.agency.bgColor) {
      return property.agency.bgColor;
    }
  }

  getAgentImage(property) {
    if (property && property.agent && property.agent.photo) {
      return 'url(' + environment.S3_URL + property.agent.photo.url + ')';
    }
  }

  getSlidePhotosLarge(photo) {
    // Image Detail Large Image Slider - # - 1
    return 'url(' + environment.S3_URL + photo.url + ')';
  }

  getSlidePhotosThumb(photo) {
    return 'url(' + environment.S3_URL + photo.thumb + ')';
  }

  getSlidePhotos(property) {
    if (property && property.photos && property.photos[0] && property.photos[0].thumb) {
      return 'url(' + environment.S3_URL + property.photos[0].thumb + ')';
    }
  }

  setDetailsScript() {
    setTimeout(function () {
      let isFound = false;
      const scripts = document.getElementsByTagName('script');
      for (let i = 0; i < scripts.length; ++i) {
        if (scripts[i].getAttribute('src') !== null && scripts[i].getAttribute('src').includes('loader')) {
          isFound = true;
        }
      }
      if (!isFound) {
        const dynamicScripts = [
          'assets/js/components/detail-photos.js',
          'assets/js/components/trending.js',
          'assets/js/components/verified.js',
          'assets/js/components/detail-agent.js',
          'assets/js/components/popup.js'
        ];
        for (let i = 0; i < dynamicScripts.length; i++) {
          const node = document.createElement('script');
          node.src = dynamicScripts[i];
          node.type = 'text/javascript';
          node.async = false;
          node.charset = 'utf-8';
          document.getElementsByTagName('head')[0].appendChild(node);
        }
      }
    }, 500);
  }

  checkMap() {
    this.showMap = true;
  }

  // Trending propery load in same page added function
  loadTrendingProp(url) {
    this.router
      .navigateByUrl('/RefrshComponent', { skipLocationChange: false })
      .then(() => this.router.navigate([url]));
  }

  setScroll(type) {
    const detailTopPosition = $('.detail-info-text__container p').offset().top - 20;
    const mapTopPosition = $('.detail-map').offset().top - 100;
    if (type === 1) {
      if ($('.more').is(':visible')) {
        $('.detail-info-text__read-more-btn').trigger('click');
      }
      if (!isPlatformServer(this.platformId)) {
        // If not the server
        window.scrollTo(0, detailTopPosition);
      }
    }
    if (type === 2) {
      if (!isPlatformServer(this.platformId)) {
        // If not the server
        window.scrollTo(0, mapTopPosition);
      }
    }
  }

  amenitiesListing(list) {
    if (list) {
      return list.replace(/_/g, ' ').toLowerCase();
    }
  }
}
