# noembed Snippet / Output Modifier

The noembed Snippet / Output Modifier can be used as an output modifier for placeholders or as a stand alone snippet with provided &link=``

```
[[noembed?link=`http://www.youtube.com/watch?v=bDOYN-6gdRE`]]
```
Or
```
[[+video:noembed]]
```

By default noembed just outputs an iframe of your video, but you can customize it further by passing either ```&tpl=`yourtpl` ``` or by passing a tpl name to the output modifier's options 
```
[[+video:noembed=`yourtpl`]]
```
The tpl will give you the following placeholders: 

| Placeholder | Description |
| --- | --- |
| [[+width]] | (int) Width of the returned resource |
| [[+author_name]] | The name of the author/owner of the resource. |
| [[+author_url]] | A URL for the author/owner of the resource. |
| [[+version]] | The noembed version number. |
| [[+provider_url]] | The url of the resource provider. |
| [[+provider_name]] | The name of the resource provider. |
| [[+thumbnail_width]] | (int) Thumbnail width |
| [[+thumbnail_url]] | URL to default thumbnail |
| [[+height]] | (int) Height of the returned resource |
| [[+thumbnail_height]] | (int) Thumbnail height |
| [[+html]] | Resource iframe embed _(default output)_ |
| [[+url]] | URL to the resource _(default output if no html)_ |
| [[+type]] | The resource type (photo, video, link, rich) |
| [[+title]] | A text title, describing the resource. |

To learn more about noembed visit [https://noembed.com/](https://noembed.com/)