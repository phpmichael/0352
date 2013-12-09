<?
$filters_model = load_model('filters_model');

if(!isset($filters_section)) $filters_section = $BC->_getController();

if($filters_model->available())
{
    $filters_groups = $filters_model->getFiltersForSection($filters_section);
    
    if(!empty($filters_groups))
    {
?>

    <h2 class="fl"><?=language('filters')?></h2>
    
    <span class="fr"><?=$filters_model->resetFilterAnchor()?></span>
    
    <div class="section-filters clear">
        <?foreach ($filters_groups as $filter_group):?>
        <ul>
            <li><?=$filter_group['title']?>
                <ul>
                    <?foreach ($filter_group['filters'] as $filter):?>
                    <li><?=$filters_model->filterAnchor($filter['id'],$filter['title'])?></li>
                    <?endforeach?>
                </ul>
            </li>
        </ul>
        <?endforeach?>
    </div> 

<?
    }
} 
?>