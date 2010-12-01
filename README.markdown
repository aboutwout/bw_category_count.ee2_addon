# BW Category Count

BW Category Count is an ExpressionEngine 2.x add-on that adds a {category_count} variable to the {exp:channel:entries} loop. Which show the number of categories assigned to the current entry.

Put the ext.bw_category_count.php file in '/system/expressionengine/third_party/bw_category_count/', install the extension in the CP and you're all set.

### Usage

    {exp:channel:entries channel='blog'}
      {if category_count == 0}
        No categories assigned to this post.
      {if:else}
        {categories backspace='1'}
          <a href="{path='blog'}">{category_name}</a>, 
        {/categories}
      {/if}
    {/exp:channel:entries}

### Parameters

`show_group [optional]` The show\_group parameter allows you to only count a category if it is in a specific category group, much like how the show\_group parameter on the categories-loop works.

    {category_count show_group='1'}
    {category_count show_group='1|3|4'}
    {category_count show_group='not 2'}
    {category_count show_group='not 2|3'}