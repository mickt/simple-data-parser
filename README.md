This is a simple and free Wordpress article parser.

To work parser, you must first specify a path to a page with a list of articles that you need to mate.

Next, in format XPath you need to specify the way to the reference to the article on the source page, so you will indicate what links the plugin should be packed.

In the format, but already on the article page you should indicate the title of the article and the bodies of the article.

In some checkboxes, you can turn on the loading of images into the body of the article, the reunion of the body of the article from references, scripts and clear tags from classes and aid.

Separately, you have the opportunity to indicate to what category the posts of your site should be attached to new information and make sure that the positions created are initially in the draft section.

A number of explanation on work with Xpath. Conditionally you have a supposed one you have a source of articles with https://website.com/articles where is approximately the next List of Articles

```
<div id="articles_list">
	<ul>
		<li class="list_item">
			<div class="thumb"><img src="..." /></div>
			<div class="title"><a href="link_to_article">Some name</a></div>
		</li>
		..............
	</ul>
</div>
```
In this case, XPath for our references on articles will
```
//*[@id='articles_list']//*[contains(@class, 'title')]//a
```
To indicate the title of the article is enough to simply specify the title tag
```
//h1
```
For the body of the article is about the same if we have a source of such a source
```
<div id="content">
	<div class="container">
		<div class="article_body">
			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
		</div>
	</div>
</div>
```
then for the body of the article you can specify such a way
```
//*[@id='content']//*[contains(@class, 'article_body')]
```
