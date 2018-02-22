<?php
/**
 * Hooking into FAQ module through a class in order to create new input
 * field. Used to tag articles as 'Private FAQ'.
 */
class PrivateFAQExtension extends DataExtension implements PermissionProvider {

    /**
     * The permission code used to access private FAQ's
     *
     * @var string
     */
    const FAQPRIVATE_ACCESS_CODE = 'FAQ_PRIVATE_QUESTIONS_ACCESS';

    /**
     * @var array
     */
    private static $db = [
        'PrivateFAQ' => 'Boolean'
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'PrivateFAQ' => 'Private FAQ'
    ];

    /**
     * @param  FieldList $fields
     *
     * @return void
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab(
            'Root.Main',
            CheckboxField::create('PrivateFAQ', 'Mark as Private FAQ')
                ->setDescription('FAQ articles marked as private will only be visible to authenticated users.')
        );
    }

    /**
     * Used by {@link PermissionProvider} to create a custom permission code
     * that we will use to enable users to access private FAQ's.
     *
     * @return array
     */
    public function providePermissions()
    {
        return [
            self::FAQPRIVATE_ACCESS_CODE => [
                'name' => 'Access to the private FAQs in the knowledge base',
                'category' => 'FAQ Private Questions',
            ]
        ];
    }

    /**
     * Ensures that the current user is part of the group which has permission
     * to view 'Private FAQs'
     *
     * @param Member|null $member
     *
     * @return boolean
     */
    public function updateCanView($member = null, &$canView)
    {
        if (!Permission::check('FAQ_PRIVATE_QUESTIONS_ACCESS')) {
            if ($this->owner->PrivateFAQ) {
                $canView = false;
            }
        }
    }
}
