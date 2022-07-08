
<div id="top"></div>

<div align="center">

<img src="https://svg-rewriter.sachinraja.workers.dev/?url=https%3A%2F%2Fcdn.jsdelivr.net%2Fnpm%2F%40mdi%2Fsvg%406.7.96%2Fsvg%2Ftable-row.svg&fill=%239A3412&width=200px&height=200px" style="width:200px;"/>

<h3 align="center">Page-Builder Metafizzy Flickity</h3>

<p align="center">
    This is Metafizzy Flickity built for the custom Page-Builder project.
</p>    
</div>

##  1. <a name='TableofContents'></a>Table of Contents


* 1. [Table of Contents](#TableofContents)
* 2. [About The Project](#AboutTheProject)
	* 2.1. [Built With](#BuiltWith)
	* 2.2. [Installation](#Installation)
* 3. [Usage](#Usage)
* 4. [Customising](#Customising)
* 5. [Troubleshooting](#Troubleshooting)
* 6. [Contributing](#Contributing)
* 7. [License](#License)
* 8. [Contact](#Contact)
* 9. [Changelog](#Changelog)



##  2. <a name='AboutTheProject'></a>About The Project

ACF-Based panels to allow you to create shortcodes for flickity sliders.

<p align="right">(<a href="#top">back to top</a>)</p>


###  2.1. <a name='BuiltWith'></a>Built With

This project was built with the following frameworks, technologies and software.

* [https://github.com/IORoot/wp-plugin__page-builder](https://github.com/IORoot/wp-plugin__page-builder)
* [Tailwind](https://tailwindcss.com/)
* [ACF](https://advancedcustomfields.com/)
* [PHP](https://php.net/)
* [Wordpress](https://wordpress.org/)

<p align="right">(<a href="#top">back to top</a>)</p>


###  2.2. <a name='Installation'></a>Installation


These are the steps to get up and running with this plugin.

1. Clone the repo into your wordpress plugin folder
    ```bash
    git clone https://github.com/IORoot/wp-plugin__page-builder--flickity ./wp-content/plugins/page-builder-flickity
    ```
1. Activate the plugin.


> Note: This plugin requires the page-builder plugin to work [https://github.com/IORoot/wp-plugin__page-builder](https://github.com/IORoot/wp-plugin__page-builder)

<p align="right">(<a href="#top">back to top</a>)</p>

##  3. <a name='Usage'></a>Usage

The Flickity slider will now be available through the page-builder as an "organism" to include into the page.

The organism has five tabs to use:

### Flickity

1. Title. This is the instance 'slug' of the slider.
1. Classes. Any class names you wish to add to the containing wrapper of the flickity slider.
1. Flickity Arguments. All arguments are documented here: [https://flickity.metafizzy.co/options.html](https://flickity.metafizzy.co/options.html). A JSON object. 
For instance:
```JSON
{ "cellAlign": "left", "contain": true, "pageDots": false }
```

![Flickity Tab](https://github.com/IORoot/wp-plugin__page-builder--flickity/blob/master/files/docs/flickity.png?raw=true)


### WP_Query

1. WP_Query. This is a PHP array of options for the wordpress WP_Query. Everything is documented here: [WP_Query](https://developer.wordpress.org/reference/classes/wp_query/)

Example:
```php
[
    'post_type' => 'pulse',
    'post_status' => 'publish',
    'order' => 'DESC',
    'numberposts' => 30,
	'tax_query' => [
        [
            'taxonomy' => 'pulse_category',
            'field' => 'slug',
            'terms' => 'curated-accounts'
        ],
    ],
]
```

![WP_Query Tab](https://github.com/IORoot/wp-plugin__page-builder--flickity/blob/master/files/docs/wp_query.png?raw=true)

### Grid

1. Vertical Stack. You can have multiple items stacked on top of each other in a column if you prefer. Enter the number of items here.
1. Vertical-Stack Classes. The class names to give the entire column wrapper.
1. Sub-cell Classes. The class names for each item within the column.

![Grid Tab](https://github.com/IORoot/wp-plugin__page-builder--flickity/blob/master/files/docs/grid.png?raw=true)

### Cells

1. Template. This is how to render each item. This is quite powerful since you describe the layout of each item with the dynamic fields inserted using moustache-bracket formatting.
Example:
```php
<a class="block text-white pl-4 lg:pl-10 w-60 lg:w-80" href="{{youtube_video_link}}" target="_blank">
	<div class="border border-fog hover:border-smoke">
	
		<img class="w-full h-32 lg:h-48 bg-night bg-cover bg-center lazyload" src="{{image_url}}" srcset="{{image_srcset}}" />
		
		<div class="p-4 bg-black ">
    		<div class="truncate">{{post_title}}</div>
			<div class="truncate text-xs text-crayon">{{channelTitle}}</div>
    		<div class="text-smoke">{{time_ago}} ago.</div>
		</div>
	</div>
</a>
```
In the example you can see there are post items such as: 
- Meta fields like `{{youtube_video_link}}`
- Post fields like `{{post_title}}`
- Image fields like `{{image_url}}` 
And there are many more.

There is a help tab to describe the functionality available.

#### Template usage
The template is the HTML layout of each cell combined with the use of `{{moustache}}` code.

#### Moustaches
The moustaches will do one of three things:

Substitute a POST field with its value. So, `{{post_content}}` will be replaced with the actual post content.
Substitute a META field for its value. The meta fields will allow you to insert custom data in the cell. So something like `{{video_link}}` (if set) will become the text in that field.

Lastly, there are a number of custom moustaches that do various custom functions. Some are specific to LondonParkour / Parkourpulse.

#### Custom Moustaches

`{{admin}}`.
`{{article_media_type}}`.
`{{article_taxonomy}}`.
`{{ig_media_type}}`.
`{{image_url:SIZE}}`. You can use the size argument to any size used in `get_the_post_thumbnail_url()`
`{{itunes_link}}`.
`{{mixed_link}}`.
`{{mixed_source}}`.
`{{mixed_username}}`.
`{{post_permalink}}`.
`{{time_ago}}`.
`{{youtube_channel_link}}`.
`{{youtube_playlist_link}}`.
`{{youtube_video_link}}`.

![Cells Tab](https://github.com/IORoot/wp-plugin__page-builder--flickity/blob/master/files/docs/cells.png?raw=true)

### CSS

1. Inline additional CSS. Add a `<style>` tag above the flickity instance with these rules in it.

![CSS Tab](https://github.com/IORoot/wp-plugin__page-builder--flickity/blob/master/files/docs/css.png?raw=true)


##  4. <a name='Customising'></a>Customising

None.

##  5. <a name='Troubleshooting'></a>Troubleshooting

None.

<p align="right">(<a href="#top">back to top</a>)</p>


##  6. <a name='Contributing'></a>Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue.
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



##  7. <a name='License'></a>License

Distributed under the MIT License.

MIT License

Copyright (c) 2022 Andy Pearson

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

<p align="right">(<a href="#top">back to top</a>)</p>



##  8. <a name='Contact'></a>Contact

Author Link: [https://github.com/IORoot](https://github.com/IORoot)

<p align="right">(<a href="#top">back to top</a>)</p>


##  9. <a name='Changelog'></a>Changelog

v1.0.0 - Initial Release
