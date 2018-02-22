<?php

class KnowledgebaseSearchIndexPrivateExtension extends DataExtension
{

    /**
     * Using this hook to add our own custom fields to the {@link KnowledgebaseSearchIndex}.
     *
     * @param KnowledgebaseSearchIndex $index
     */
    public function onAfterInit($index)
    {
        $index->addFilterField('PrivateFAQ');
    }

}
