A total of four BBCodes are included:

- Rating
- Individual rating
- Positive / Negative arguments
- Call-to-action-button


**Rating**

This BB code generates a box with an overall rating. Optionally, the summary can be hidden:

`[rating="1-5 Stars","0 to hide the summary"]Summary[/rating]`

Application example BB code with summary:

```
[rating=2.7]

Duis autem

Duis autem vel eum iriure dolor in hendrerit in vulputate velit…

[/rating]
```


**Single rating**

This BB code generates a single rating:

`[ratingbar=3]Title[/ratingbar]`


**Positive and negative arguments**

This BB code generates lists with which positive and negative properties can be displayed. To do this, two enumeration lists must be created within the tags (see toolbar editor). The first list is formatted as positive, the second list as negative.

Example:

```
[ratingarguments]
• Lorem ipsum dolor
• Lorem ipsum dolor
• Lorem ipsum dolor
• Lorem ipsum dolor

• Nam liber tempor
• Nam liber tempor
• Nam liber tempor
• Nam liber tempor
[/ratingarguments]
```

Only application lists are formatted (the ones with the dots). The code block does generally not display lists, which is why the example is not suitable for copying.


**Call-to-action button**

This BB code formats a text link as a primary button.

Example:

`[cta]Link[/cta]`


**BB codes that are not required**

BB codes that are not required can be hidden in the editor:

ACP -> Content - BB Codes -> [rating] / [ratingbar] / [ratingarguments] / [cta] -> Show button in WYSIWYG editor